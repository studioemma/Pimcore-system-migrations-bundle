<?php

namespace StudioEmma\SystemMigrationsBundle;

abstract class SystemUpdate
{
    const BUILDNR = 0;

    protected $db = null;

    public function __construct()
    {
        $this->db = \Pimcore\Db::get();
    }

    public function run()
    {
        $updateTo = (int) \Pimcore\Version::getRevision();

        if ($updateTo >= static::BUILDNR) {
            return $this->goUp();
        }
        return $this->goDown();
    }

    private function goUp()
    {
        $this->db->beginTransaction();
        if ($this->mustGoUp()) {
            $this->up();
        }
        $this->successfullUp();
        $this->db->commit();
    }

    private function goDown()
    {
        // start transaction
        $this->db->beginTransaction();
        if (! $this->mustGoDown()) {
            $this->down();
        }
        $this->successfullDown();
        $this->db->commit();
    }

    private function mustGoUp()
    {
        $record = $this->getRevisionRecord();
        if (false === $record) {
            return true;
        }

        if (empty($record['updatedDate'])) {
            return true;
        }

        return false;
    }

    private function successfullUp()
    {
        $now = new \DateTimeImmutable('now');
        $data = [
            'pimcore_build' => static::BUILDNR,
            'updatedDate' => $now->getTimestamp(),
        ];
        return $this->updateRevisionRecord($data);
    }

    private function mustGoDown()
    {
        $record = $this->getRevisionRecord();
        if (false === $record) {
            return false;
        }

        if (empty($record['updatedDate'])) {
            return false;
        }

        return true;
    }

    private function successfullDown()
    {
        $data = [
            'pimcore_build' => static::BUILDNR,
            'updatedDate' => null,
        ];
        return $this->updateRevisionRecord($data);
    }

    private function getRevisionRecord()
    {
        $sql = 'SELECT * FROM `plugin_se_system_migrations`'
            . ' WHERE `pimcore_build` = ?';
        $record = $this->db->fetchRow($sql, [static::BUILDNR]);
        return $record;
    }

    private function updateRevisionRecord(array $data)
    {
        $record = $this->getRevisionRecord();

        if (false !== $record
            && !empty($record['updatedDate'])
            && !empty($data['updatedDate'])) {
            return true;
        }
        return $this->db->insertOrUpdate(
            'plugin_se_system_migrations',
            $data
        );
    }

    abstract protected function up();

    abstract protected function down();
}