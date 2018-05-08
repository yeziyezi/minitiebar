<?php
namespace frontend\controllers;
use yii\web\Controller;
use common\models\Post;
use Yii;
use yii\base\Security;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;
use common\models\Bar;
use yii\web\HttpException;
use common\models\PostSearch;
use yii\data\ActiveDataProvider;
use common\models\Reply;
use yii\helpers\Html;
class PostController extends Controller{
    public function actionList(){
            $bar_id=Bar::find()->where(['name'=>Yii::$app->request->get('bar-name')])->one();
            if($bar_id===null){
                throw new NotFoundHttpException("该吧不存在！");
                return;
            }
            $dataProvider=new ActiveDataProvider([
                'query'=>Post::find()->where(['bar_id'=>$bar_id])->orderBy('last_reply_time DESC'),
                'pagination'=>[
                    'pagesize'=>10,
                ]   
            ]);
        return $this->render('index',[
            'dataProvider'=>$dataProvider,                
        ]);
    }
    public function actionAdd(){
        $barName= Yii::$app->request->get('bar-name');
        $bar=Bar::find()->where(['name'=>$barName])->one();
        if($bar===null){
            throw new NotFoundHttpException("该吧不存在！");
            return;
        }
        $model=new Post();
        $security=new Security();
        if($model->load(Yii::$app->request->post())){
            $model->content=Html::encode($model->content);
            $model->title=Html::encode($model->title);
            $model->reply_number=0;
            $model->publish_time=Date('Y-m-d H:i:s');
            $model->last_reply_time=$model->publish_time;
            $model->publish_user=Yii::$app->user->id;
            $model->id='p-'.$security->generateRandomString(36);
            $model->bar_id=$bar->id;
            if($model->validate()&&$model->save()){
                $this->redirect(['post/list','bar-name'=>$bar->name]);
            }else{
                throw new HttpException('500','发贴失败，请稍后重试'); 
            }           
        }
        return $this->render('add',[
            'model'=>$model,
            'barName'=>$barName,
        ]);
    }
    public function actionDetail(){
        if(Yii::$app->request->isPjax){//如果是pjax请求，则一定是来自页面上的按钮点击，根据提交的参数渲染回复悬浮框
            $type=Yii::$app->request->get('type');
            $id=Yii::$app->request->get('id');
            return $this->renderReplyXNavbar($type,$id);        
        }else{
            $post_id=Yii::$app->request->get('post_id');
            $model=Post::findOne($post_id);
            if($model===null){
                throw new NotFoundHttpException("该贴子不存在！");
                return;
            }
            $replyDataProvider=new ActiveDataProvider([
                'query'=>Reply::find()->where(['post_id'=>$post_id])->orderBy('publish_time ASC'),
                'pagination'=>[
                    'pagesize'=>20
                ]
            ]);
            return $this->render('detail',[
                'replyDataProvider'=>$replyDataProvider,
                'model'=>$model,
                'post_id'=>$post_id,
                'replyXNavbar'=>$this->renderReplyXNavbar('post',$post_id)    
            ]);
        }
        
        
        
        
    }

    protected function renderReplyXNavbar($type,$id){
        $that=clone($this);//如果不用一个去掉默认布局的控制器对象，_replyPostNavbar渲染的子视图将会带有main.php的布局，使页面代码混乱
        $that->layout=false;
        // type:reply post innerReply 
        $functionName='renderReply'.ucwords(strtolower($type)).'Navbar';
        return $this->$functionName($that,$id);
    }
    
    protected function renderReplyPostNavbar(object $renderModel,string $post_id){//渲染回复
        return $renderModel->render('_replyPostNavbar',[
            'post_id'=>$post_id,
        ]);
    }
    public function renderReplyReplyNavbar(object $renderModel,string $reply_id){
        return  $renderModel->render('_replyReplyNavbar',[
            'reply_id'=>$reply_id,
        ]);
    }
    public function renderReplyInnerReplyNavbar(object $renderModel,string $inner_reply_id){
        return $renderModel->render('_replyInnerReplyNavbar',[
            'inner_reply_id'=>$inner_reply_id,
        ]);
    }
}