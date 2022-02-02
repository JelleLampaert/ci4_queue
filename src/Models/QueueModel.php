<?php namespace jellelampaert\ci4_queue\Models;

use CodeIgniter\Model;

class QueueModel extends Model
{
    protected $table = 'queue';

    public function cleanAllOldTasks($hours)
    {
        $this->db->table($this->table)->where('processed > ', 0)->where('processed < ', time() - ($hours * 3600))->delete();
    }

    public function cleanOldTasks($queue, $hours)
    {
        $this->db->table($this->table)->where('queue', $queue)->where('processed > ', 0)->where('processed < ', time() - ($hours * 3600))->delete();
    }

    public function deleteTask($id)
    {
        $this->db->table($this->table)->where('id', $id)->delete();
    }

    public function getAllTasks($queue)
    {
        $dbdata = $this->db->table($this->table)->where('queue', $queue)->orderBy('created', 'DESC')->get()->getResult();
        foreach ($dbdata as &$data) {
            $data->data = unserialize(base64_decode($data->data));
            $data->response = unserialize(base64_decode($data->response));
        }
        return $dbdata;
    }

    public function getAllUnprocessed()
    {
        $dbdata = $this->db->table($this->table)->where('processed', 0)->get()->getResult();
        foreach ($dbdata as &$data) {
            $data->data = unserialize(base64_decode($data->data));
            $data->response = unserialize(base64_decode($data->response));
        }
        return $dbdata;
    }

    public function getTask($id)
    {
        return $this->db->table($this->table)->where('id', $id)->get()->getRow();
    }

    public function getUnprocessed($queue)
    {
        $dbdata = $this->db->table($this->table)->where('processed', 0)->where('queue', $queue)->get()->getResult();
        foreach ($dbdata as &$data) {
            $data->data = unserialize(base64_decode($data->data));
            $data->response = unserialize(base64_decode($data->response));
        }
        return $dbdata;
    }
    
    public function queue($queue, $data)
    {
        $this->db->table($this->table)->insert(array(
            'queue'     => $queue,
            'data'      => base64_encode(serialize($data)),
            'created'   => time()
        ));
    }

    public function setProcessed($id)
    {
        $this->db->table($this->table)->where('id', $id)->update(array(
            'processed' => time()
        ));
    }

    public function setResponse($id, $data)
    {
        $this->db->table($this->table)->where('id', $id)->update(array(
            'response'  => base64_encode(serialize($data)),
        ));
    }
}