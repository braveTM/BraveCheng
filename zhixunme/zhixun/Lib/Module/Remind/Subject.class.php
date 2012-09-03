<?php
require_once('Observer.class.php');
/**
 * 被观察者
 *
 * @author moi
 */
class Subject implements SplSubject{
    protected $_observers;
    
    protected $_key;

    public function  __construct($key) {
        $this->_observers = new SplObjectStorage();
        $this->_key = $key;
    }

    /**
     * 添加观察者
     * @param Observer $observer 
     */
    public function attach(SplObserver $observer) {
        $this->_observers->attach($observer);
    }

    /**
     * 移除观察者
     * @param Observer $observer
     */
      public function detach(SplObserver $observer) {
          $this->_observers->detach($observer);
      }
 
      /**
       * 通知观察者
       */
      public function notify() {
          foreach ($this->_observers as $observer) {
              $observer->update($this);
          }
      }

      public function get_key(){
          return $this->_key;
      }
}
?>
