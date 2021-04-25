<?php
/**
 * Default Controller class - Контроллер графического редактора
 *
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */
class ImgeditorController{

    /**
     * @var string - Имя модуля контроллера (Внимание, оно должно соответствовать свойству $thisModuleName фронт контроллера модуля (используется во View)
     */
    public $thisModuleName = '';
    
    public function __construct($thisModuleName) {
        $this->thisModuleName = $thisModuleName;
    }

    /**
     * Метод по-умолчанию
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_index($tpl_mode='html', $console=false){
        $this->action_hello($tpl_mode, $console);//Покажем хелп
    }

    /**
     * Вывод страницы помощи
     * @param string $tpl_mode - формат вывода
     * @param bool $console - если true, то вывод в консоль
     */
    public function action_hello($tpl_mode='html', $console=false){
        //if (Glob::$vars['user']->get('userid')==0) MNBVf::redirect('/intranet/auth/'); //Если неавторизованный пользователь, перебросим на авторизацию !!!!!!!!!!!!!!!!!!!!!!!!!!!
        
        Glob::$vars['page_title'] = Glob::$vars['page_keywords'] = Glob::$vars['page_description'] = Glob::$vars['page_h1'] = Lang::get("Image editor"); //Метатеги
        SysLogs::addLog("Page_title: ". Glob::$vars['page_title']);
        
        $item = array(); //Массив данных, передаваемых во View

        $act = SysBF::checkStr(SysBF::getFrArr(Glob::$vars['request'],'act',''),'strictstr');

        switch ($act){

            case 'upload': //Закачка изображения
                //Подключим библиотеку обработки изображений
                require_once MNBVf::getRealFileName(MNBV_MAINMODULE, MOD_MODELSPATH . '/MNBVImg.class.php');

                //Загрузим параметры конфигурации панели работы с приложенными изображениями
                $maxSizeConf = MNBVf::getImgMaxSize('photo_editor',Glob::$vars['img_max_size']);

                if (empty($_FILES["ufimg"]["error"])) { // Если загрузка прошла успешно
                    $filetype = MNBVf::getFileType($_FILES["ufimg"]['name']); //Определим тип файла
                    $filename0 = 'img' . Glob::$vars['session']->sid . '.' . $filetype;
                    $filename = APP_DUMPPATH . Glob::$vars['mnbv_module'] . '/' . $filename0;

                    if ($imgProp=MNBVImg::imageResize($filename,$_FILES["ufimg"]['tmp_name'],$filetype,$maxSizeConf['img_max_w'],$maxSizeConf['img_max_h'],$maxSizeConf['img_quality'],$maxSizeConf['img_update'])){
                        SysLogs::addLog("Upload $filename0  to TMP complite!");
                        Glob::$vars['session']->set('img_editor_file',$filename0);
                        Glob::$vars['session']->set('img_editor_file_w',$imgProp['w']);
                        Glob::$vars['session']->set('img_editor_file_h',$imgProp['h']);
                    } else {
                        SysLogs::addError('Error: Upload '.$filename0.' to TMP!');
                    }

                }else{
                    SysLogs::addError("Error: Upload file!");
                }
                break;

            case 'delete': //Удаление изображения

                //Если файл есть локально, то удалим
                if ($filename0 = Glob::$vars['session']->get('img_editor_file')){
                    $filename = APP_DUMPPATH . Glob::$vars['mnbv_module'] . '/' . $filename0;
                    if (file_exists($filename)==1) {
                        chmod("$filename",0666);
                        $dlres=unlink($filename);
                    }
                    Glob::$vars['session']->del('img_editor_file');
                    Glob::$vars['session']->del('img_editor_file_w');
                    Glob::$vars['session']->del('img_editor_file_h');
                    SysLogs::addLog("Delete $filename0 from TMP complite!");
                }
                break;

            case 'update': //Редактирование изображения

                $filename0 = Glob::$vars['session']->get('img_editor_file');
                if (!empty($filename0)){
                    $filetype = MNBVf::getFileType($filename0); //Определим тип файла
                    $filename = APP_DUMPPATH . Glob::$vars['mnbv_module'] . '/' . $filename0;
                    $maxSizeConf = MNBVf::getImgMaxSize('photo_editor',Glob::$vars['img_max_size']);
                    $quality = intval($maxSizeConf['img_quality']);
                    $imgWidth = Glob::$vars['session']->get('img_editor_file_w');
                    $imgHeight = Glob::$vars['session']->get('img_editor_file_h');
                    $th_w = intval(SysBF::getFrArr(Glob::$vars['request'],'th_w',0));
                    $th_h = intval(SysBF::getFrArr(Glob::$vars['request'],'th_h',0));
                    $x1_inp  = intval(SysBF::getFrArr(Glob::$vars['request'],'x1_inp',0));
                    $y1_inp = intval(SysBF::getFrArr(Glob::$vars['request'],'y1_inp',0));
                    $x2_inp = intval(SysBF::getFrArr(Glob::$vars['request'],'x2_inp',0));
                    $y2_inp = intval(SysBF::getFrArr(Glob::$vars['request'],'y2_inp',0));

                    if (($th_w==$imgWidth && $th_h==$imgHeight)||(empty($x1_inp)&&empty($y1_inp))) {
                        SysLogs::addLog("Image Redactor: No changes!");
                        break;
                    } //Нет изменений размеров

                    //Проверка типов входного и выходного изображения и входное и выходное изображения должны быть разрешенных типов
                    $trueTypesArr = array(
                        "jpg" => "jpg",
                        "jpeg" => "jpg",
                        "png" => "png",
                        "gif" => "gif",
                        "bmp" => "bmp",
                    );
                    if (empty($trueTypesArr["$filetype"])) {
                        SysLogs::addError("MNBVImg::imageResize Error: Wrong [$filename0] type=".$filetype."!");
                        break;
                    }

                    $out_type = $trueTypesArr[$filetype];

                    if ($out_type == 'jpg') $im = imagecreatefromjpeg($filename);
                    elseif ($out_type == 'png') $im = imagecreatefrompng($filename);
                    elseif ($out_type == 'gif') $im=imagecreatefromgif($filename);
                    elseif ($out_type == 'bmp') $im=imagecreatefromwbmp($filename);
                    else break; //Если разрешенного расширения не нашлось, выходим

                    $im1=imagecreatetruecolor($th_w,$th_h); //Создает изображение результат с заданными размерами

                    if (($out_type=='gif')or($out_type=='png')){
                        imageAlphaBlending($im1, false);
                        imageSaveAlpha($im1, true);
                    }

                    imagecopyresampled($im1,$im,0,0,$x1_inp,$y1_inp,$th_w,$th_h,$x2_inp-$x1_inp,$y2_inp-$y1_inp);//Меняем изображение

                    //Записывает изображение в файл результат
                    if ($out_type == 'jpg') imagejpeg($im1,$filename,$quality);
                    elseif ($out_type == 'png') imagepng($im1,$filename,ceil($quality/10 - 1));
                    elseif ($out_type == 'gif') imagegif($im1,$filename);
                    elseif ($out_type == 'bmp') imagewbmp($im1,$filename);

                    imagedestroy($im); //Уничтожает изображение источник
                    imagedestroy($im1); //Уничтожает изображение результат

                    Glob::$vars['session']->set('img_editor_file_w',$th_w);
                    Glob::$vars['session']->set('img_editor_file_h',$th_h);

                }

                break;

        }

        $filename0 = '';
        if (isset(Glob::$vars['session'])) {
            $filename0 = Glob::$vars['session']->get('img_editor_file');
        }
        if (!empty($filename0)){
            $item["img_editor_file"] = WWW_DUMPPATH . Glob::$vars['mnbv_module'] . '/' .Glob::$vars['session']->get('img_editor_file');
            $item["img_editor_file_w"] = Glob::$vars['session']->get('img_editor_file_w');
            $item["img_editor_file_h"] = Glob::$vars['session']->get('img_editor_file_h');
            $item["img_editor_view"] = true;
        }
        
        $PgHtml = '';
        $item['page_content'] = $PgHtml;
        $item['page_h1'] = Glob::$vars['page_h1'];
        $item['page_sctpl'] = 'tpl_imgeditor.php'; //Шаблон
        
        //Запишем конфиг и логи----------------------
        $script_datetime_stop = date("Y-m-d G:i:s");
        $script_time_stop = SysBF::getmicrotime();
        $time_script = sprintf ("%01.4f",($script_time_stop - Glob::$vars['time_start']));
        SysLogs::addLog('Starttime: ' . Glob::$vars['datetime_start']);
        SysLogs::addLog("Endtime: $script_datetime_stop");
        SysLogs::addLog("Runtime: $time_script");

        //View------------------------
        MNBVf::render(MNBVf::getRealTplName(Glob::$vars['mnbv_tpl'], 'main_blank.php'),$item,$tpl_mode);

    }
	
}

