<?php
namespace Home\Controller;
use Think\Controller;
class AdminController extends Controller {
    public function groupList(){
        //$this->this = D('User')->Index();
        $group = D('Admin');
        $groupArr = $group->getList();
        //$this->view->assign('article',$groupArr);
        $this->article = $groupArr;
        $this->view->display();
    }


    /* 添加组操作*/
    public function groupManage(){
       $this->view->display();
    }
       /* 添加组元素操作*/
    public function groupAdd(){
       $group = trim($_POST['group']);
       $groupMember = trim($_POST['groupMember']);
       if(empty($group)||empty($groupMember)){
            $this->error('add error',U('Admin/groupManage'),3);
       }
       $groupMemberArr = explode("，",$groupMember);
       foreach($groupMemberArr as $v){
       $value = $this->trimSpace($v);
       $data [] = array(
            'vtype' => $group,
            'vuser' => $value
        );
       }
       $list = D('Admin');
       $res = $list->addList($data);
       if($res){
        $this->success('add ok',U('Admin/groupManage'),3);
       }else{
        $this->error('add error',U('Admin/groupManage'),3);
       }
    }

    //删除空格
    function trimSpace($str)
    {
        $qian=array(" ","　","\t","\n","\r");
        $hou=array("","","","","");
        return str_replace($qian,$hou,$str);    
    }



}
