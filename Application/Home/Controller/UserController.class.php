<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
    public function index(){
        //$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>[ 您现在访问的是Home模块的Index控制器 ]</div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
        $publish = D('Publish');
        $contentData = $publish->getMsg();
        $vUserTypeObj = D('Vuser');
        $vUserType = $vUserTypeObj->getVtype();
        $this->vUserType = $vUserType;
        $this->contentData = $contentData;
        $userName = session('name');
        if($userName){
            $this->view->assign('username',$userName);
            $this->display();
        }else{
            $this->redirect('Index/login');

        }
    }
    public function publishMsg(){
        $msg = trim($_POST['publish']);
        $vType = trim($_POST['vtypeselect']);
        $userName = session('name');
        $data = array(
            'user'=>$userName,
            'content'=>$msg,
            'ctime'=>time(),
            'vtype'=>$vType
        );
        $publish = D('Publish');
        $res = $publish->addMsg($data); 
        if($res!=false){
            $this->redirect('User/index');
        }
        else{
            $this->error("加入数据库失败");
        }
    }
    public function getComment(){
        $pid = $_POST['pid'];
        $commentObj = D('Comment');
        $commentMsg = $commentObj->getComment($pid);
        foreach($commentMsg as $key=> $list){
        $commentMsg[$key]['ctime'] = date("Y-m-d H:i:s",$list['ctime']);
        }
        echo json_encode($commentMsg); 
    }
    public function postComment(){
        $contentComment = $_POST['content'];
        $pid = $_POST['pid'];
        $userName = session('name');
        $data = array(
            'pid' => $pid,
            'content' => $contentComment,
            'ctime' => time(),
            'user' => $userName 
        );
        if($userName == null){
            return ;
        }
        else{
        $commentObj = D('Comment');
        $commentMsg = $commentObj->addComment($data,0);
        $commentMsg['ctime'] = date("Y-m-d H:i:s",time());
        //获取评论数目
        $publish = D('Publish');
        $publishData = $publish->getMsgbyId($pid);
        $commentMsg['comment_num'] = $publishData['comment_num'];
        echo json_encode($commentMsg); 
        }
   }
}
