<?php

namespace Shelter\Bus;

use Evenement\EventEmitterTrait;
use inisire\NetBus\Event\CallableSubscription;
use inisire\NetBus\Event\EventBusInterface;
use inisire\NetBus\Event\EventInterface;
use inisire\NetBus\Event\Subscription\Matches;
use inisire\NetBus\Event\Subscription\Wildcard;
use Psr\Log\LoggerInterface;
use Shelter\Bus\Event\DiscoverRequest;
use Shelter\Core\Device;
use Shelter\Bus\Event\DeviceUpdateEvent;
use Shelter\Bus\Event\DiscoverResponse;

class DeviceRegistry implements \Shelter\Core\DeviceRegistry
{
    use EventEmitterTrait;

    /**
     * @var array<string,Device>
     */
    private array $devices = [];

    public function __construct(
        private readonly string            $busId,
        private readonly EventBusInterface $eventBus,
        private readonly LoggerInterface   $logger,
        private readonly DeviceFactory     $deviceFactory
    )
    {
        $this->eventBus->subscribe(new CallableSubscription(
            new Wildcard(excludes: [$this->busId]),
            new Matches([Events::DISCOVER_RESPONSE, Events::DEVICE_UPDATE]),
            function (EventInterface $event) {
                $data = $event->getData();
                match ($event->getName()) {
                    Events::DISCOVER_RESPONSE => $this->handleDiscoverResponse(new DiscoverResponse($data['device'], $data['model'], $data['properties'])),
                    Events::DEVICE_UPDATE => $this->handleDeviceUpdate(new DeviceUpdateEvent($data['device'], $data['properties'])),
                };
            }
        ));
    }

    public function startDeviceDiscovery(): void
    {
        $this->eventBus->dispatch($this->busId, new DiscoverRequest($this->busId));
    }

    public function handleDiscoverResponse(DiscoverResponse $event): void
    {
        $this->logger->debug('Discover response', ['device' => $event->device, 'properties' => $event->properties]);

        $device = $this->devices[$event->device] ?? null;

        if (!$device) {
            $device = $this->deviceFactory->createByModel($event->model, $event->device, new MutableState($event->properties));
            $this->devices[$event->device] = $device;
            $this->emit('discovered', [$device]);
        } else {
            $device->updateProperties($event->properties);
        }
    }

    public function handleDeviceUpdate(DeviceUpdateEvent $event): void
    {
        $this->logger->debug('Device updated', ['device' => $event->device, 'properties' => $event->properties]);

        $device = $this->devices[$event->device] ?? null;

        if ($device) {
            $device->updateProperties($event->properties);
        } else {
            $this->logger->error('Device not registered', ['device' => $event->device]);
        }
    }

    public function onDiscovered(callable $handler): void
    {
        $this->on('discovered', $handler);
    }

    public function find(string $id): ?Device
    {
        return $this->devices[$id] ?? null;
    }

    /**
     * @return iterable<Device>
     */
    public function findAll(): iterable
    {
        return $this->devices;
    }

    public function save(Device $device): void
    {
        $this->devices[$device->getId()] = $device;
    }
}