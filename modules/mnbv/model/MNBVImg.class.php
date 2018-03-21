<?php
/**
 * MNBVImg.class.php Библиотека функций работы с изображениями
 * 
 * Created by Konstantin Khachaturyan (aga-c4)
 * @author Konstantin Khachaturyan (AGA-C4)
 * Date: 09.04.15
 * Time: 00:00
 */


class MNBVImg {

    /**
     * Изменяет размеры изображения и при необходимости обрезает или растягивает
     * @param $outfile название результирующего файла
     * @param $infile название входного файла
     * @param $infile тип входного файла если 'frname', то берется из названия входного файла
     * @param $maxw максимальная ширина результата
     * @param $maxh максимальная высота результата
     * @param int $quality качество результата, %
     * @param string $crop  Варианты: "none" - пропорционально сжать, "crop-top" - пропорционально по мин измерению и от верха обрезать лишнее, "crop-center" - пропорционально по мин измерению и от центра обрезать лишнее.
     */
    public static function imageResize($outfile,$infile,$inFileTtype,$maxw,$maxh,$quality=100,$crop='none') {

        //Проверка типов входного и выходного изображения и входное и выходное изображения должны быть разрешенных типов
        $trueTypesArr = array(
            "jpg" => "jpg",
            "jpeg" => "jpg",
            "png" => "png",
            "gif" => "gif",
            "bmp" => "bmp",
        );
        $filetype_in = ($inFileTtype=='frname')?MNBVf::getFileType($infile):$inFileTtype;
        $filetype_out = MNBVf::getFileType($outfile);
        if (empty($trueTypesArr["$filetype_in"])||empty($trueTypesArr["$filetype_out"])) {
            SysLogs::addError("MNBVImg::imageResize Error: Wrong [$infile] typeIn=".$filetype_in." ==> [$outfile] typeOut=".$filetype_out);
            return false;
        }
        $out_type = $trueTypesArr[$filetype_out];
        $in_type = $trueTypesArr[$filetype_in];

        //Проверка на максимально допустимый размер изображения
        $maximgw=15000;
        $maximgh=15000;
        list($imgWidth, $imgHeight) = getimagesize($infile); //Узнаем реальный размер изображения на входе
        if ($imgWidth>$maximgw || $imgHeight>$maximgh) {
            SysLogs::addError("MNBVImg::imageResize Error: Wrong imgSize=[$imgWidth/$imgHeight] maxSize=[$maximgw/$maximgh]");
            return false;
        }

        //Зададим базовые размеры
        $neww=$imgWidth; //Ширина на выходе
        $newh=$imgHeight; //Высота на выходе

        //Посмотрим пропорции
        $vidprop = $maxw/$maxh; //>1 - ландшафт, менее - портрет
        $vidprop2 = $imgWidth/$imgHeight; //>1 - ландшафт, менее - портрет

        $x1_inp=0; //Координаты X точки отчета блока захвата
        $y1_inp=0; //Координаты У точки отчета блока захвата

        if($crop == 'crop-top') { //пропорциональное сжатие по оси с минимальной разницей с последующей обрезкой по другой оси

            //Вычислим конечную ширину и высоту изображения
            $propw=$maxw/$imgWidth;
            $proph=$maxh/$imgHeight;

            $block_w=$imgWidth; //Ширина блока обреза
            $block_h=$imgHeight; //Высота блока обреза

            //Прямые пропорции, тут мы учитываем
            if ($vidprop>$vidprop2){ //Делаем по ширине
                $neww=floor($imgWidth*$propw);
                if ($maxw>$neww){$neww=$maxw;}
                $newh=floor($imgHeight*$propw);
                if ($maxh>$newh){$newh=$maxh;}

                if ($maxh<$newh){//Если высота исходника более чем требуется, то вырежем блок из середины
                    $newh=$maxh;//Высоту установым в максимальную допустимую
                    $block_h=ceil($maxh/$propw);//Рассчитаем исходную требуемую высоту, чтоб выделить блок захвата
                    $y1_inp=0; //$y1_inp=ceil(($imgHeight-$block_h)/2);//Рассчитаем координаты У точки отчета блока захвата
                }
            } else { //Делаем по высоте
                $neww=floor($imgWidth*$proph);
                if ($maxw>$neww){$neww=$maxw;}
                $newh=floor($imgHeight*$proph);
                if ($maxh>$newh){$newh=$maxh;}

                if ($maxw<$neww){//Если ширина исходника более чем требуется, то вырежем блок из середины
                    $neww=$maxw;//Ширину установым в максимальную допустимую
                    $block_w=ceil($maxw/$proph);//Рассчитаем исходную требуемую высоту, чтоб выделить блок захвата
                    $x1_inp=ceil(($imgWidth-$block_w)/2);//Рассчитаем координаты У точки отчета блока захвата
                }
            }

        }elseif($crop == 'crop-center') { //пропорционально по мин измерению и от центра обрезать лишнее

            //Вычислим конечную ширину и высоту изображения
            $propw=$maxw/$imgWidth;
            $proph=$maxh/$imgHeight;

            $block_w=$imgWidth; //Ширина блока обреза
            $block_h=$imgHeight; //Высота блока обреза

            //Прямые пропорции, тут мы учитываем
            if ($vidprop>$vidprop2){ //Делаем по ширине
                $neww=floor($imgWidth*$propw);
                if ($maxw>$neww){$neww=$maxw;}
                $newh=floor($imgHeight*$propw);
                if ($maxh>$newh){$newh=$maxh;}

                if ($maxh<$newh){//Если высота исходника более чем требуется, то вырежем блок из середины
                    $newh=$maxh;//Высоту установым в максимальную допустимую
                    $block_h=ceil($maxh/$propw);//Рассчитаем исходную требуемую высоту, чтоб выделить блок захвата
                    $y1_inp=ceil(($imgHeight-$block_h)/2);//Рассчитаем координаты У точки отчета блока захвата
                }
            } else { //Делаем по высоте
                $neww=floor($imgWidth*$proph);
                if ($maxw>$neww){$neww=$maxw;}
                $newh=floor($imgHeight*$proph);
                if ($maxh>$newh){$newh=$maxh;}

                if ($maxw<$neww){//Если ширина исходника более чем требуется, то вырежем блок из середины
                    $neww=$maxw;//Ширину установым в максимальную допустимую
                    $block_w=ceil($maxw/$proph);//Рассчитаем исходную требуемую высоту, чтоб выделить блок захвата
                    $x1_inp=ceil(($imgWidth-$block_w)/2);//Рассчитаем координаты У точки отчета блока захвата
                }
            }

        } else {//Без обрезания, пропорционально в заданных рамках tip==0

            //Вычислим конечную ширину и высоту изображения
            if ($imgWidth>$maxw){$propw=$maxw/$imgWidth;}else{$propw=1;}
            if ($imgHeight>$maxh){$proph=$maxh/$imgHeight;}else{$proph=1;}

            $block_w=$imgWidth; //Ширина блока обреза
            $block_h=$imgHeight; //Высота блока обреза

            if ($vidprop<$vidprop2){ //Прямые пропорции, тут мы учитываем
                if ($maxw<=$neww){$neww=($imgWidth>$maxw)?$maxw:$imgWidth;$newh=floor($imgHeight*$propw);}//Делаем по ширине
                else {$newh=($imgHeight>$maxh)?$maxh:$imgHeight;$neww=floor($imgWidth*$proph);}//Делаем по высоте
            } else { //Делаем по высоте
                if ($maxh<=$newh){$newh=($imgHeight>$maxh)?$maxh:$imgHeight;$neww=floor($imgWidth*$proph);}//Делаем по ширине
                else {$neww=($imgWidth>$maxw)?$maxw:$imgWidth;$newh=floor($imgHeight*$propw);}//Делаем по высоте
            }
        }

        //Открывает изображение источника
        if ($in_type == 'jpg') $im = imagecreatefromjpeg($infile);
        elseif ($in_type == 'png') $im = imagecreatefrompng($infile);
        elseif ($in_type == 'gif') $im=imagecreatefromgif($infile);
        elseif ($in_type == 'bmp') $im=imagecreatefromwbmp($infile);
        else return false; //Если разрешенного расширения не нашлось, выходим

        $im1=imagecreatetruecolor($neww,$newh); //Создает изображение результат с заданными размерами

        if (($out_type=='gif')or($out_type=='png')){
            imageAlphaBlending($im1, false);
            imageSaveAlpha($im1, true);
        }

        if (($propw==1)and($proph==1)){
            $im1=$im;//Не надо менять изображение, просто копируем
            $noM1 = true;
        }else{
            imagecopyresampled($im1,$im,0,0,$x1_inp,$y1_inp,$neww,$newh,$block_w,$block_h);//Меняем изображение т.к. оно больше разрешенного
        }

        //Записывает изображение в файл результат
        if ($out_type == 'jpg') imagejpeg($im1,$outfile,$quality);
        elseif ($out_type == 'png') imagepng($im1,$outfile,ceil($quality/10 - 1));
        elseif ($out_type == 'gif') imagegif($im1,$outfile);
        elseif ($out_type == 'bmp') imagewbmp($im1,$outfile);

        imagedestroy($im); //Уничтожает изображение источник
        if (empty($noM1))imagedestroy($im1); //Уничтожает изображение результат

        //Все хорошо, вернем сведения по вновь созданному файлу
        $outFilesize = ceil(filesize($outfile)/1024);
        $result = array('w'=>$neww,'h'=>$newh,'kb'=>$outFilesize,'type'=>$filetype_out);
        return $result;
    }


    /**
     * Рисует график доработать потом
     * @param $DATA
     * @param $W
     * @param $H
     */
    public static function imgCreateGraph($DATA,$W,$H){
        //http://www.php.su/articles/?cat=graph&page=013
        // Задаем входные данные ############################################

        // Входные данные - три ряда, содержащие случайные данные.
        // Деление на 2 и 3 взято для того чтобы передние ряды не
        // пересекались

        // Массив $DATA["x"] содержит подписи по оси "X"

        //        $DATA=Array();
        //        for ($i=0;$i<20;$i++) {
        //            $DATA[0][]=rand(0,100);
        //            $DATA[1][]=rand(0,100)/2;
        //            $DATA[2][]=rand(0,100)/3;
        //            $DATA["x"][]=$i;
        //        }

        // Задаем изменяемые значения #######################################

        // Размер изображения

        //        $W=16384;
        //        $H=8192;

        // Отступы
                $MB=20;  // Нижний
                $ML=8;   // Левый
                $M=5;    // Верхний и правый отступы.
                // Они меньше, так как там нет текста

        // Ширина одного символа
                $LW=imagefontwidth(2);

        // Подсчитаем количество элементов (точек) на графике
                $count=count($DATA[0]);
                if (count($DATA[1])>$count) $count=count($DATA[1]);
                if (count($DATA[2])>$count) $count=count($DATA[2]);

                if ($count==0) $count=1;

        // Сглаживаем графики ###############################################
                if ($_GET["smooth"]==1) {

                    // Добавим по две точки справа и слева от графиков. Значения в
                    // этих точках примем равными крайним. Например, точка если
                    // y[0]=16 и y[n]=17, то y[1]=16 и y[-2]=16 и y[n+1]=17 и y[n+2]=17

                    // Такое добавление точек необходимо для сглаживания точек
                    // в краях графика

                    for ($j=0;$j<3;$j++) {
                        $DATA[$j][-1]=$DATA[$j][-2]=$DATA[$j][0];
                        $DATA[$j][$count]=$DATA[$j][$count+1]=$DATA[$j][$count-1];
                    }

                    // Сглаживание графики методом усреднения соседних значений

                    for ($i=0;$i<$count;$i++) {
                        for ($j=0;$j<3;$j++) {
                            $DATA[$j][$i]=($DATA[$j][$i-1]+$DATA[$j][$i-2]+
                                    $DATA[$j][$i]+$DATA[$j][$i+1]+
                                    $DATA[$j][$i+2])/5;
                        }
                    }
                }


        // Подсчитаем максимальное значение
                $max=0;

                for ($i=0;$i<$count;$i++) {
                    $max=$max<$DATA[0][$i]?$DATA[0][$i]:$max;
                    $max=$max<$DATA[1][$i]?$DATA[1][$i]:$max;
                    $max=$max<$DATA[2][$i]?$DATA[2][$i]:$max;
                }

        // Увеличим максимальное значение на 10% (для того, чтобы столбик
        // соответствующий максимальному значение не упирался в в границу
        // графика
                $max=intval($max+($max/10));

        // Количество подписей и горизонтальных линий
        // сетки по оси Y.
                $county=10;

        // Работа с изображением ############################################

        // Создадим изображение
                $im=imagecreate($W,$H);

        // Цвет фона (белый)
                $bg[0]=imagecolorallocate($im,255,255,255);

        // Цвет задней грани графика (светло-серый)
                $bg[1]=imagecolorallocate($im,231,231,231);

        // Цвет левой грани графика (серый)
                $bg[2]=imagecolorallocate($im,212,212,212);

        // Цвет сетки (серый, темнее)
                $c=imagecolorallocate($im,184,184,184);

        // Цвет текста (темно-серый)
                $text=imagecolorallocate($im,136,136,136);

        // Цвета для линий графиков
                $bar[2]=imagecolorallocate($im,191,65,170);
                $bar[0]=imagecolorallocate($im,161,155,0);
                $bar[1]=imagecolorallocate($im,65,170,191);

                $text_width=0;
        // Вывод подписей по оси Y
                for ($i=1;$i<=$county;$i++) {
                    $strl=strlen(($max/$county)*$i)*$LW;
                    if ($strl>$text_width) $text_width=$strl;
                }

        // Подравняем левую границу с учетом ширины подписей по оси Y
                $ML+=$text_width;

        // Посчитаем реальные размеры графика (за вычетом подписей и
        // отступов)
                $RW=$W-$ML-$M;
                $RH=$H-$MB-$M;

        // Посчитаем координаты нуля
                $X0=$ML;
                $Y0=$H-$MB;

                $step=$RH/$county;

        // Вывод главной рамки графика
                imagefilledrectangle($im, $X0, $Y0-$RH, $X0+$RW, $Y0, $bg[1]);
                imagerectangle($im, $X0, $Y0, $X0+$RW, $Y0-$RH, $c);

        // Вывод сетки по оси Y
                for ($i=1;$i<=$county;$i++) {
                    $y=$Y0-$step*$i;
                    imageline($im,$X0,$y,$X0+$RW,$y,$c);
                    imageline($im,$X0,$y,$X0-($ML-$text_width)/4,$y,$text);
                }

        // Вывод сетки по оси X
        // Вывод изменяемой сетки
                for ($i=0;$i<$count;$i++) {
                    imageline($im,$X0+$i*($RW/$count),$Y0,$X0+$i*($RW/$count),$Y0,$c);
                    imageline($im,$X0+$i*($RW/$count),$Y0,$X0+$i*($RW/$count),$Y0-$RH,$c);
                }

        // Вывод линий графика
                $dx=($RW/$count)/2;

                $pi=$Y0-($RH/$max*$DATA[0][0]);
                $po=$Y0-($RH/$max*$DATA[1][0]);
                $pu=$Y0-($RH/$max*$DATA[2][0]);
                $px=intval($X0+$dx);

                for ($i=1;$i<$count;$i++) {
                    $x=intval($X0+$i*($RW/$count)+$dx);

                    $y=$Y0-($RH/$max*$DATA[0][$i]);
                    imageline($im,$px,$pi,$x,$y,$bar[0]);
                    $pi=$y;

                    $y=$Y0-($RH/$max*$DATA[1][$i]);
                    imageline($im,$px,$po,$x,$y,$bar[1]);
                    $po=$y;

                    $y=$Y0-($RH/$max*$DATA[2][$i]);
                    imageline($im,$px,$pu,$x,$y,$bar[2]);
                    $pu=$y;
                    $px=$x;
                }

        // Уменьшение и пересчет координат
                $ML-=$text_width;

        // Вывод подписей по оси Y
                for ($i=1;$i<=$county;$i++) {
                    $str=($max/$county)*$i;
                    imagestring($im,2, $X0-strlen($str)*$LW-$ML/4-2,$Y0-$step*$i-
                        imagefontheight(2)/2,$str,$text);
                }

        // Вывод подписей по оси X
                $prev=100000;
                $twidth=$LW*strlen($DATA["x"][0])+6;
                $i=$X0+$RW;

                while ($i>$X0) {
                    if ($prev-$twidth>$i) {
                        $drawx=$i-($RW/$count)/2;
                        if ($drawx>$X0) {
                            $str=$DATA["x"][round(($i-$X0)/($RW/$count))-1];
                            imageline($im,$drawx,$Y0,$i-($RW/$count)/2,$Y0+5,$text);
                            imagestring($im,2, $drawx-(strlen($str)*$LW)/2, $Y0+7,$str,$text);
                        }
                        $prev=$i;
                    }
                    $i-=$RW/$count;
                }

                header("Content-Type: image/png");

        // Генерация изображения
                ImagePNG($im);

                imagedestroy($im);
    }

} 