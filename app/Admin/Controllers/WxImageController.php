<?php

namespace App\Admin\Controllers;

use App\Model\WxImageModel;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class WxImageController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new WxImageModel);

        $grid->i_id('I id');
        $grid->media_id('medis_id');
        $grid->type('type');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(WxImageModel::findOrFail($id));

        $show->i_id('I id');
        $show->openid('Openid');
        $show->image('Image');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new WxImageModel);

        $form->text('openid', 'Openid');
        $form->image('image', 'Image');

        return $form;
    }
    public function addImage(Request $request){
        // $arr=$_FILES;
        // $tmp_name=$arr['img']['tmp_name'];
        // $filename=$arr['img']['name'];
        //echo $filename;die;
        // move_uploaded_file($tmp_name, "/wwwroot/1809_weixin_shop/public/wx_image/".$filename);
        $post['img']=$this->upload($request,'img'); //获得文件路径
        $access_token=accessToken();
        //echo $access_token;die;
        $url='https://api.weixin.qq.com/cgi-bin/media/upload?access_token='.$access_token.'&type=image';
        $client=new Client();
        $response=$client->request('post',$url,[
            'multipart' => [
                [
                    'name'     => 'media',
                    'contents' => fopen("../storage/app/".$post['img'], 'r')
                ]
            ]
        ]);
        $res=$response->getBody();
        $arr=json_decode($res,true);
        //echo '<pre>';print_r($arr);echo '</pre>';
        $media_id=$arr['media_id'];
        $type=$arr['type'];
        $info=[
            'media_id'=>$media_id,
            'type'=>$type
        ];
        //dd($info);
        $add=DB::table('wx_image')->insert($info);
        if($add){
            echo "ok";
        }else{
            echo "no";
        }
        // return $content
        // ->body(view('admin.WxImage.addImage'));
    }
    public function add(Content $content){
        return $content
        ->body(view('admin.WxImage.addImage'));
    }
    //群发方法
    public function sendMse($openid_arr,$content){
        $access_token=accessToken();
        $msg=[
            "touser"=>$openid_arr,
            "msgtype"=>"text",
            "text"=>[
                "content"=>$content
                 ]
            ];
        $data=json_encode($msg,JSON_UNESCAPED_UNICODE);
        $url='https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token='.$access_token;
        $client=new Client();
        $response=$client->request('post',$url,[
            'body'=>$data
        ]);
        return $response->getBody();
    }
    //群发（数据库数据查询出来）
    public function send(Content $content){
        $where=[
            'status'=>1
        ];
        $arr=DB::table('userwx')->where($where)->get()->toArray();
        //var_dump($arr);die;
     
         //dd($openid_arr);
        
        return $content
        ->body(view('admin.WxImage.send',['arr'=>$arr]));
    }
    //群发
    public function sendTo(){
        $count=request()->input('text');
        $id=request()->input('openid');
        $openid=explode(',',$id);
        // print_r($openid);
        // echo $count;
       $access_token=accessToken();
       $msg=[
           "touser"=>$openid,
           "msgtype"=>"text",
           "text"=>[
               "content"=>$count
                ]
           ];
       $data=json_encode($msg,JSON_UNESCAPED_UNICODE);
       $url='https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token='.$access_token;
       $client=new Client();
       $response=$client->request('post',$url,[
           'body'=>$data
       ]);
       $res=$response->getBody();
       $arr=json_decode($res,true);
       if($arr){
            echo "ok";
       }else{
            echo "no";
       }
      // echo'<pre>';print_r($arr);echo'</pre>';
    }
    //添加文件
    public function upload(Request $request,$fieldname){
        //判断是否上传 是否错误
        if ($request->hasFile($fieldname) && $request->file($fieldname)->isValid()) {
            $photo = $request->file($fieldname);
           // $extension = $photo->extension();
            //$store_result = $photo->store('photo');
            $store_result = $photo->store('uploads/'.date('Ymd'));
            //返回一个路径
            return $store_result;
            }
    }
    //标签添加
    public function tally(){
        $name=request()->input('name');
        //echo $name;die;
        $access_token=accessToken();
        $url='https://api.weixin.qq.com/cgi-bin/tags/create?access_token='.$access_token;
        $a=[
            "tag" =>["name"=>$name ]
        ];
        $data=json_encode($a,JSON_UNESCAPED_UNICODE);
        //echo $data;die;
        $client=new Client();
        $response=$client->request('post',$url,[
            'body'=>$data
        ]);
       $res=$response->getBody();
       $arr=json_decode($res,true);
       //echo'<pre>';print_r($arr);echo'</pre>';
    }
    //标签添加视图
    public function tallyAdd(Content $content){
        return $content
        ->body(view('admin.WxImage.tallyAdd'));
    }
    //标签展示
    public function tallyList(Content $content){
        $access_token=accessToken();
        $url='https://api.weixin.qq.com/cgi-bin/tags/get?access_token='.$access_token;
        $response=json_decode(file_get_contents($url),true);
        //  echo'<pre>';print_r($response);echo'</pre>';
        $arr=$response['tags'];
        return $content
        ->body(view('admin.WxImage.tallyList',['arr'=>$arr]));
    }
    //批量给用户加标签（执行）
    public function make(){
        $a=request()->input('openid');
        //echo $a;
        $openid=explode(',',$a);
       // echo'<pre>';print_r($openid);echo'</pre>';die;
        $label=request()->input('label');
       
        $access_token=accessToken();
        $url='https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token='.$access_token;
        $data=[
            
            "openid_list" =>[//粉丝列表    
                $openid,    
                ],   
                "tagid" =>$label
          
        ];
        $a=json_encode($data,JSON_UNESCAPED_UNICODE);
        // echo $a;
        $client=new Client();
        $response=$client->request('post',$url,[
            'body'=>$a
        ]);
        $arr=$response->getBody();
        $res=json_decode($arr,true);
        dd($res);
    }
    //给用户添加标签(展示)
    public function mass(Content $content){
           
            //展示出用户
            $userInfo=DB::table('userwx')->get()->toArray();
            // $user=array_column($userInfo,'openid');
            // dd($userInfo);
            //展示标签
            $access_token=accessToken();
            $url='https://api.weixin.qq.com/cgi-bin/tags/get?access_token='.$access_token;
            $response=json_decode(file_get_contents($url),true);
            //  echo'<pre>';print_r($response);echo'</pre>';
            $arr=$response['tags'];
            return $content
            ->body(view('admin.WxImage.mass',['arr'=>$arr,'userInfo'=>$userInfo]));
    }
    public function Info(){
        $id=request()->input('id');
        $text=request()->input('text');
        $access_token=accessToken();
        $url='https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token='.$access_token;
        $a=[
            "filter"=>[
                "is_to_all"=>false,
                "tag_id"=>$id
             ],
             "text"=>[
                "content"=>$text
             ],
              "msgtype"=>"text"
        ];
        $data=json_encode($a,JSON_UNESCAPED_UNICODE);
        //echo $data;die;
        $client=new Client();
        $response=$client->request('post',$url,[
            'body'=>$data
        ]);
       $res=$response->getBody();
       $arr=json_decode($res,true);
       echo'<pre>';print_r($arr);echo'</pre>';
    }
    

}
