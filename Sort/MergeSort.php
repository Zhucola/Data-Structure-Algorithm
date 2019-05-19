<?php
/*
    归并长度为15的数组
    左面
        mSort(0,7)
         mSort(0,3)
          mSort(0,1)
          merge(0,0,1)
         mSort(2,3)
         merge(2,2,3)
         merge(0,1,3)
        mSort(4,7)
         mSort(4,5)
          merge(4,4,5)
        mSort(6,7)
         merge(6,6,7)
        merge(4,5,7)
        merge(0,3,7)
    右面以此类推
*/
include("./Base.php");
final class mergeSort1 extends Base
{
    public function __construct($count){
        parent::__construct($count);
        $this->mSort(0,$this->count-1);
    }

    private function mSort($left,$right)
    {
        if($left<$right){
            $center = (int)floor(($left+$right)/2);
            $this->mSort($left,$center);
            $this->mSort($center+1,$right);
            $this->merge($left,$center,$right);
        }
    }
    private function merge($left,$center,$right)
    {
        $min = $left;
        $max = $center + 1;
        //归并排序最大的问题就是空间复杂度，所需要的空间和N成正比
        $tmp = [];
        while($min <= $center && $max <= $right){
            if($this->less($this->arr[$max],$this->arr[$min])){
                $tmp[] = $this->arr[$min++];
            }else{
                $tmp[] = $this->arr[$max++];
            }
        }
        while($min<=$center){
            $tmp[] = $this->arr[$min++];
        }
        while($max<=$right){
            $tmp[] = $this->arr[$max++];
        }
        for($i=0;$i<count($tmp);$i++){
            $this->arr[$left+$i] = $tmp[$i];
        }
    }
}

//原地归并优化
final class mergeSort2 extends Base
{
    public $tmp = [];
    public function __construct($count){
        parent::__construct($count);
        $this->mSort(0,$this->count-1);
    }

    private function mSort($left,$right)
    {
        if($left<$right){
            $center = (int)floor(($left+$right)/2);
            $this->mSort($left,$center);
            $this->mSort($center+1,$right);
            $this->merge($left,$center,$right);
        }
    }
    private function merge($left,$center,$right)
    {
        $min = $left;
        $max = $center + 1;
        for($i=$left;$i<=$right;$i++){
            $this->tmp[$i] = $this->arr[$i];
        }
        for($j=$left;$j<=$right;$j++){
            if($min>$center){
                $this->arr[$j] = $this->tmp[$max++];
            }elseif($max>$right){
                $this->arr[$j] = $this->tmp[$min++];
            }elseif($this->less($this->tmp[$max],$this->tmp[$max])){
                $this->arr[$j] = $this->tmp[$max++];
            }else{
                $this->arr[$j] = $this->tmp[$min++];
            }
        }
    }
}
// $sort = new mergeSort1(10000);
// var_dump($sort->check());
// $sort->elapsedTime();

$sort = new mergeSort2(10000);
var_dump($sort->check());
$sort->elapsedTime();