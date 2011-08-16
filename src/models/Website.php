<?php
class Website {
    protected $id;
    protected $website;
    
    public function getId() {return $this->id; }
    public function setId($id) { $this->id = $id; }
    public function getWebsite() { return $this->website; }
    public function setWebsite($website) { $this->website = $website; }
    public function getOrder() { return $this->order; }
    public function setOrder($order) { $this->order = $order; }

}
?>
