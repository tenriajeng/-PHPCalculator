<?php

namespace Jakmall\Recruitment\Calculator\History\Infrastructure;

//TODO: create implementation.
interface CommandHistoryManagerInterface
{
    /**
     * Returns array of command history.
     *
     * @return array returns an array of commands in storage
     */
    public function findAll($driver, $id = array()): array;

    /**
     * Find a command by id.
     *
     * @param string|int $id
     *
     * @return null|mixed returns null when id not found.
     */
    public function find($id);

    /**
     * Log command data to storage.
     *
     * @param mixed $command The command to log.
     *
     * @return bool Returns true when command is logged successfully, false otherwise.
     */
    public function log($command): bool;

    /**
     * Clear a command by id
     *
     * @param string|int $id
     *
     * @return bool Returns true when data with $id is cleared successfully, false otherwise.
     */
    public function clear($drive, $id): bool;

    /**
     * Clear all data from storage.
     *
     * @return bool Returns true if all data is cleared successfully, false otherwise.
     */
    public function clearAll($driver): bool;

    /**
     * Clear all data from storage.
     *
     * @return bool Returns true if all data is cleared successfully, false otherwise.
     */
    public function saveToDriver($content, $name): void;

    /**
     * filter data from storage.
     *
     * @return bool Returns true if all data is cleared successfully, false otherwise.
     */
    public function filter($data, $id);
}
