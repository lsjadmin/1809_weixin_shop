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
        $text=request()->input('text');
        $openid=request()->input('openid');
        //  echo $openid;
        // echo $text;
        $res=$this->sendMse($openid,$text);
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

    

}
