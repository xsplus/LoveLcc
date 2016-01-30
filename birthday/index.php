<!DOCTYPE>
<html>
<head>
    <title>Happy Birthday</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
</head>
<body>
<?php
function IsMobile()
{
    //如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if(isset($_SERVER['HTTP_X_WAP_PROFILE']))  return TRUE;
    //如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if(isset($_SERVER['HTTP_VIA']))
    {
        //找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    //判断手机发送的客户端标志,兼容性有待提高
    if(isset($_SERVER['HTTP_USER_AGENT']))
    {

        $clientkeywords = array('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile');

        //从HTTP_USER_AGENT中查找手机浏览器的关键字
        if(preg_match('/('.implode('|', $clientkeywords).')/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return TRUE;
        }
    }
    //协议法，因为有可能不准确，放到最后判断
    if(isset($_SERVER['HTTP_ACCEPT']))
    {
        //如果只支持wml并且不支持html那一定是移动设备
        //如果支持wml和html但是wml在html之前则是移动设备
        if((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) &&
                (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false ||
                        (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return TRUE;
        }
    }
    return FALSE;
}
if(IsMobile()){
    ?>
<link rel="stylesheet" href="css/layout.css">
<link rel="stylesheet" href="css/style.css">
    <script src="js/zepto.min.js"></script>
    <script src="js/layout.js"></script>
    <script>
        (function() {
            var lastTime = 0;
            var vendors = ['ms', 'moz', 'webkit', 'o'];
            for (var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
                window.requestAnimationFrame = window[vendors[x] + 'RequestAnimationFrame'];
                window.cancelAnimationFrame = window[vendors[x] + 'CancelAnimationFrame'] || window[vendors[x] + 'CancelRequestAnimationFrame'];
            }
            if (!window.requestAnimationFrame) window.requestAnimationFrame = function(callback, element) {
                var currTime = new Date().getTime();
                var timeToCall = Math.max(0, 16 - (currTime - lastTime));
                var id = window.setTimeout(function() {
                    callback(currTime + timeToCall);
                }, timeToCall);
                lastTime = currTime + timeToCall;
                return id;
            };
            if (!window.cancelAnimationFrame) window.cancelAnimationFrame = function(id) {
                clearTimeout(id);
            };
        }());

        $(function() {
            document.addEventListener("touchmove", function (e) {
                e.preventDefault();
                e.stopPropagation();
            }, false);
            var next = {'bottom': '-100%'}, self = {'bottom': 0}, prev = {'bottom': '100%'};
            var ot = 500;
            var scenes = {
                'load': {
                    'ele': $('.load'), /*场景的标签*/
                    'debug': false, /*是否开启调试模式*/
                    'path': 'img/loading/', /*图片根目录*/
                    'layers': [/*场景的图层数据*/
                        {'img': 'danGao.png', x: 350, y: 633},
                        {'img': 'ce.png',"x": 351, "y": 685, "w": 370, "h": 130, "attr": {class: "load_ce _1"}},
                        {'img': 'ce.png',"x": 351, "y": 685, "w": 370, "h": 130, "attr": {class: "load_ce _2"}},
                        {'img': 'ce.png',"x": 351, "y": 685, "w": 370, "h": 130, "attr": {class: "load_ce _3"}},
                        {'img': 'ce.png',"x": 351, "y": 685, "w": 370, "h": 130, "attr": {class: "load_ce _4"}},
                        {'img': 'ce.png',"x": 351, "y": 685, "w": 370, "h": 130, "attr": {class: "load_ce _5"}},
                        {'img': 'ce.png',"x": 351, "y": 685, "w": 370, "h": 130, "attr": {class: "load_ce _6"}},
                        {"x": 474, "y": 600, "w": 18, "h": 80, "attr": {"class": "load_zhu _1"}},
                        {"x": 529, "y": 600, "w": 18, "h": 80, "attr": {"class": "load_zhu _2"}},
                        {"x": 584, "y": 600, "w": 18, "h": 80, "attr": {"class": "load_zhu _3"}},
                        {"x": 476, "y": 555, "w": 15, "h": 36, "attr": {"class": "load_zhuHuo _1"}},
                        {"x": 531, "y": 555, "w": 15, "h": 36, "attr": {"class": "load_zhuHuo _2"}},
                        {"x": 586, "y": 555, "w": 15, "h": 36, "attr": {"class": "load_zhuHuo _3"}},
                        {"y": 900, "attr": {"class": "load_wenzi text"}},
                        {"y": 1200, "attr": {"class": "load_HB text"}},
                    ],
                    'init': function () {
                        this.show();
                        $('.load_wenzi').text('loading...');
                        $('.load_HB').text('Happy Birthday!');
                        var ele = this.ele;
                        setTimeout(function () {
                            ele.css('opacity', '1');
                        }, 0);
                    }
                },
                'page1': {
                    'ele': $('.page1'), /*场景的标签*/
                    'debug': false, /*是否开启调试模式*/
                    'path': 'img/page/', /*图片根目录*/
                    'layers': [/*场景的图层数据*/
                        {'img': '1.jpg', 'isbg': true, w: 1080, h: 1920},
                        {"x": 60, "y": 300, "w": 960, "attr": {"class": "txtbox"}},
                    ],
                    'show': function () {
                        var ele = this.ele;
                        setTimeout(function () {
                            ele.css(self);
                        }, 1000);
                        setTimeout(initEvent, 1000+ot);
                        var obj = ele.get(0);
                        var words = [
                            {s: "Do", css: {'top':'20px', 'color': 'red'},class:'first'},
                            {s: "you", css: {'top':'20px'}},
                            {s: "understand", css: {'top':'20px'}},
                            {s: "the ", css: {'top':'20px'}},
                            {s: "feeling ", css: {'top':'20px'}},
                            {s: "of", css: {'top':'20px'}},
                            {s: "missing", css: {'top':'20px'}},
                            {s: "someone?", css: {'top':'20px'}},

                            {s: "It", css: {'top':'20px', 'color': 'red'},class:'first'},
                            {s: "is", css: {'top':'20px'}},
                            {s: "just", css: {'top':'20px'}},
                            {s: "like", css: {'top':'20px'}},
                            {s: "that", css: {'top':'20px'}},
                            {s: "you", css: {'top':'20px'}},
                            {s: "will", css: {'top':'20px'}},
                            {s: "spend", css: {'top':'20px'}},
                            {s: "a", css: {'top':'20px'}},
                            {s: "long", css: {'top':'20px'}},
                            {s: "hard", css: {'top':'20px'}},
                            {s: "time", css: {'top':'20px'}},
                            {s: "to", css: {'top':'20px'}},
                            {s: "turn", css: {'top':'20px'}},
                            {s: "the", css: {'top':'20px'}},
                            {s: "ice-cold", css: {'top':'20px'}},
                            {s: "water", css: {'top':'20px'}},
                            {s: "you", css: {'top':'20px'}},
                            {s: "have", css: {'top':'20px'}},
                            {s: "drunk", css: {'top':'20px'}},
                            {s: "into", css: {'top':'20px'}},
                            {s: "tears.", css: {'top':'20px'}},
                        ];
                        var box = ele.children('.txtbox');
                        for (var i = 0, n = words.length; i < n; i++) {
                            (function (s) {
                                var txt = $('<a class="txt x2">' + s.s + '</a>');
                                txt.addClass(s.class).css(s.css);
                                box.append(txt);
                                if(i == 7) box.append('<br><br><br>');
                            })(words[i])
                        }
                        obj.show = function () {
                            ele.find('.txtbox .txt').each(function (t, e) {
                                var T = t * 500 + ot;
                                if(t > 7) T += 1000;
                                words[t].id = setTimeout(function () {
                                    $(e).css({'opacity': 1, 'top': 0});
                                }, T)
                            })
                        }
                        obj.hide = function () {
                            ele.find('.txtbox .txt').each(function (t, e) {
                                clearTimeout(words[t].id);
                                $(e).css(words[t].css).css('opacity', 0);
                            })
                        }
                    },
                },
                'page2': {
                    'ele': $('.page2'), /*场景的标签*/
                    'debug': false, /*是否开启调试模式*/
                    'path': 'img/page/', /*图片根目录*/
                    'layers': [/*场景的图层数据*/
                        {'img': '2.jpg', 'isbg': true, w: 1080, h: 1920},
                        {"x": 60, "y": 400, "w": 960, "attr": {"class": "txtbox"}},
                    ],
                    'init': function () {
                        var ele = this.ele;
                        var obj = ele.get(0);
                        var words = [
                            {s: "There", css: {'top':'20px', 'color': 'red'},class:'first'},
                            {s: "is", css: {'top':'20px'}},
                            {s: "such", css: {'top':'20px'}},
                            {s: "a", css: {'top':'20px'}},
                            {s: "lot", css: {'top':'20px'}},
                            {s: "of", css: {'top':'20px'}},
                            {s: "things", css: {'top':'20px'}},
                            {s: "on", css: {'top':'20px'}},
                            {s: "the", css: {'top':'20px'}},
                            {s: "world", css: {'top':'20px'}},
                            {s: "to", css: {'top':'20px'}},
                            {s: "see.", css: {'top':'20px'}},

                            {s: "I", css: {'top':'20px', 'color': 'red'},class:'first'},
                            {s: "will", css: {'top':'20px'}},
                            {s: "go", css: {'top':'20px'}},
                            {s: "together", css: {'top':'20px'}},
                            {s: "with", css: {'top':'20px'}},
                            {s: "you.", css: {'top':'20px'}},
                        ];
                        var box = ele.children('.txtbox');
                        for (var i = 0, n = words.length; i < n; i++) {
                            (function (s) {
                                var txt = $('<a class="txt x2">' + s.s + '</a>');
                                txt.addClass(s.class).css(s.css);
                                box.append(txt);
                                if(i == 11) box.append('<br><br><br>');
                            })(words[i])
                        }
                        obj.show = function () {
                            ele.find('.txtbox .txt').each(function (t, e) {
                                var T = t * 500 + ot;
                                if(t > 11) T += 1000;
                                words[t].id = setTimeout(function () {
                                    $(e).css({'opacity': 1, 'top': 0});
                                }, T)
                            })
                        }
                        obj.hide = function () {
                            ele.find('.txtbox .txt').each(function (t, e) {
                                clearTimeout(words[t].id);
                                $(e).css(words[t].css).css('opacity', 0);
                            })
                        }
                    }
                },
                'page3': {
                    'ele': $('.page3'), /*场景的标签*/
                    'debug': false, /*是否开启调试模式*/
                    'path': 'img/page/', /*图片根目录*/
                    'layers': [/*场景的图层数据*/
                        {'img': '3.jpg', 'isbg': true, w: 1080, h: 1920},
                        {"x": 60, "y": 400, "w": 960, "attr": {"class": "txtbox"}},
                    ],
                    'init': function () {
                        var ele = this.ele;
                        var obj = ele.get(0);
                        var words = [
                            {s: "Cache", css: {'top':'20px', 'color': 'red'},class:'first'},
                            {s: "one's", css: {'top':'20px'}},
                            {s: "heart,", css: {'top':'20px'}},
                            {s: "never", css: {'top':'20px'}},
                            {s: "be", css: {'top':'20px'}},
                            {s: "apart.", css: {'top':'20px'}},
                        ];
                        var box = ele.children('.txtbox');
                        for (var i = 0, n = words.length; i < n; i++) {
                            (function (s) {
                                var txt = $('<a class="txt x2">' + s.s + '</a>');
                                txt.addClass(s.class).css(s.css);
                                box.append(txt);
                            })(words[i])
                        }
                        obj.show = function () {
                            ele.find('.txtbox .txt').each(function (t, e) {
                                var T = t * 500 + ot;
                                words[t].id = setTimeout(function () {
                                    $(e).css({'opacity': 1, 'top': 0});
                                }, T)
                            })
                        }
                        obj.hide = function () {
                            ele.find('.txtbox .txt').each(function (t, e) {
                                clearTimeout(words[t].id);
                                $(e).css(words[t].css).css('opacity', 0);
                            })
                        }
                    }
                },
                'page4': {
                    'ele': $('.page4'), /*场景的标签*/
                    'debug': false, /*是否开启调试模式*/
                    'path': 'img/page/', /*图片根目录*/
                    'layers': [/*场景的图层数据*/
                        {'img': '4.jpg', 'isbg': true, w: 1080, h: 1920},
                        {"x": 60, "y": 400, "w": 960, "attr": {"class": "txtbox"}},
                    ],
                    'init': function () {
                        var ele = this.ele;
                        var obj = ele.get(0);
                        var words = [
                            {s: "Happy", css: {'top':'20px', 'color': 'red'},class:'first'},
                            {s: "birthday", css: {'top':'20px'}},
                            {s: "to", css: {'top':'20px'}},
                            {s: "you", css: {'top':'20px'}},
                            {s: "of", css: {'top':'20px'}},
                            {s: "the", css: {'top':'20px'}},
                            {s: "most", css: {'top':'20px'}},
                            {s: "pretty", css: {'top':'20px'}},
                            {s: "girl", css: {'top':'20px'}},
                            {s: "in", css: {'top':'20px'}},
                            {s: "my", css: {'top':'20px'}},
                            {s: "deep", css: {'top':'20px'}},
                            {s: "heart.", css: {'top':'20px'}},
                        ];
                        var box = ele.children('.txtbox');
                        for (var i = 0, n = words.length; i < n; i++) {
                            (function (s) {
                                var txt = $('<a class="txt x2">' + s.s + '</a>');
                                txt.addClass(s.class).css(s.css);
                                box.append(txt);
                            })(words[i])
                        }
                        obj.show = function () {
                            ele.find('.txtbox .txt').each(function (t, e) {
                                var T = t * 500 + ot;
                                words[t].id = setTimeout(function () {
                                    $(e).css({'opacity': 1, 'top': 0});
                                }, T)
                            })
                        }
                        obj.hide = function () {
                            ele.find('.txtbox .txt').each(function (t, e) {
                                clearTimeout(words[t].id);
                                $(e).css(words[t].css).css('opacity', 0);
                            })
                        }
                    }
                },
                'page5': {
                    'ele': $('.page5'), /*场景的标签*/
                    'debug': false, /*是否开启调试模式*/
                    'path': 'img/page/', /*图片根目录*/
                    'layers': [/*场景的图层数据*/
                        {'img': '5.jpg', 'isbg': true, w: 1080, h: 1920},
                        { y:550,'attr': {'class': 'dg_3d_box'}}
                    ],
                    'init': function () {
                        if(init3D)init3D();
                        var ele = this.ele;
                        var obj = ele.get(0);
                        obj.show = function(){
                            $(".dg_3d_ry_animate").css(Layout._P + "animation-play-state", "running");
                        }
                        obj.hide = function(){

                        }
                    }
                },
                'common': {
                    'ele': $('.common'), /*场景的标签*/
                    'debug': false, /*是否开启调试模式*/
                    'path': 'img/common/', /*图片根目录*/
                    'layers': [/*场景的图层数据*/
                        {img:'',"x": 920, "y": 40, "w": 120,"h":120, "attr": {"class": "yinyue play"}},
                        {img:'play.png',"x": 0, "y": 400, "w": 40,"h":40, "attr": {"class": "nextImg"}},
                    ],
                    'init': function () {
                        $(".yinyue").append('<audio loop="loop" autoplay="autoplay"><source src="music.mp3" type="audio/mpeg"></audio>').on('touchstart',function(){
                            if($(this).is('.play')){
                                $(this).removeClass('play');
                                console.log($(this).find('source'))
                                $(this).find('audio').get(0).pause();
                            }else{
                                $(this).addClass('play');
                                $(this).find('audio').get(0).play();
                            }
                        })
                    }
                },
            }

            var init3D;
            var tf = Layout._P + "transform";
            // create3D
            function create3D() {
                var S = Layout.size();
                var r = (S.w >> 1) - 20;
                var a = 10;
                var W = 3391, H = 859;    //侧面展开图的长宽比
                var _a = a / 360 * Math.PI;
                var l = 2 * r * Math.sin(_a).toFixed(2);
                var oz = "translateZ(" + Math.floor(r * Math.cos(_a) - 2) + "px)";
                var h = 360 / a * l / W * H;
                var obj = {'img': 'dg_3d_s.jpg',"attr": {"class": "dg_3d_s"}, "css": {}, 'isFixed': true};
                setObjCss(obj, r << 1, r << 1, "translateX(" + ((S.w >> 1) - (r)) + "px) translateY(" + (-1-r) + "px) rotateY(158deg) rotateX(90deg)");
                var page = scenes.page5;
                page.layers.push(obj);
                for (var i = 0, n = 360/a-1; i < 360; i += a ,n--) {
                    var obj = {'img': 'dg_3d_ce.png', "attr": {"class": "dg_3d_ce"}, "css": {}, 'isFixed': true};
                    setObjCss(obj, l, h, "rotateY(" + i + "deg) " + oz)
                    obj.css['background-position'] = n * l + 'px 0';
                    page.layers.push(obj);
                }
                function setObjCss(obj, w, h, t) {
                    obj.css['width'] = w + "px";
                    obj.css['height'] = h + "px";
                    obj.css[tf] = t;
                }
                page.layers.push();
                init3D = function () {
                    var aps = Layout._P + "animation-play-state";
                    var ce = $(".dg_3d_ce").remove();
                    var s = $(".dg_3d_s").remove();
                    var dg_3d_ox = $('<div class="dg_3d_ox"></div>').css(tf, 'translateX(' + ((S.w >> 1) - (l / 2)) + 'px);').append(ce);
                    var dg_3d_ry_animate = $('<div class="dg_3d_ry_animate"></div>').append(s).append(dg_3d_ox);
                    dg_3d_ry_animate.css(aps, "paused");
                    var dg_3d_ry = $('<div class="dg_3d_ry"></div>').append(dg_3d_ry_animate);
                    var dg_3d_rx = $('<div class="dg_3d_rx"></div>').append(dg_3d_ry);
                    var ry = 5,rx = -30;
                    dg_3d_ry.css(tf, 'rotateY(' + ry + 'deg)');
                    dg_3d_rx.css(tf, 'rotateX(' + rx + 'deg)');
                    $(".dg_3d_box").append(dg_3d_rx).on('touchstart', function (event) {
                        if (event.touches.length != 1) return;
                        var posx_s = event.touches[0].pageX;
                        var posy_s = event.touches[0].pageY;
                        dg_3d_ry_animate.css(aps, "paused");
                        $(this).on('touchmove',touchmove);
                        $(this).one('touchend', function () {
                            $(this).off('touchmove',touchmove)
                            dg_3d_ry_animate.css(aps, "running");
                        })
                        function touchmove(event) {
                            if (event.touches.length != 1) return;
                            requestAnimationFrame(function () {
                                var posx_tmp = event.touches[0].pageX;
                                var posy_tmp = event.touches[0].pageY;
                                var xd = posx_tmp - posx_s;
                                var yd = posy_tmp - posy_s;
                                ry += xd * 0.4;
                                rx -= yd * 0.01;
                                if (rx > 0) rx = 0;
                                else if (rx < -40)rx = -40;
                                dg_3d_ry.css(tf, 'rotateY(' + ry + 'deg)');
                                dg_3d_rx.css(tf, 'rotateX(' + rx + 'deg)');
                                posx_s = posx_tmp;
                            })
                        }
                    })
                }
            }
            create3D();
        	var currTime;
            Layout.init(scenes, {
                loading: function (n, s) {
                    var v = (n / s).toFixed(2) * 100;
                    if(v == 100)v =99;
                    $('.load_wenzi').text('loaded ' + v + "%");
                },
                loaded: function () {
                	currTime = new Date().getTime();
                    requestAnimationFrame(timedown)
                    
                }
            });
        	
            function timedown(){
                var dt = (new Date().getTime()) - currTime;
                var v = (99+dt/5000).toFixed(1);
                $('.load_wenzi').text('loaded ' + v + "%");
                console.log(dt)
                if(dt < 5000){
                    requestAnimationFrame(timedown)
                    return;
                }
                scenes.page1.ele.addClass('show').css(next);
                setTimeout(function () {
                    scenes.page1.show();
                    scenes.common.ele.addClass('show')
                    var show = scenes.page1.ele.get(0).show;
                    if(show)show();
                }, 0)
            }
            function initEvent() {
                scenes.load.ele.remove();
                scenes.load = null;
                scenes.page2.ele.addClass('show').css(next);
                var ismoveing = false;
                var h = Layout.size('h'), p = '.page', s = 'show';
                $(".scene.page").not('.page5').on('touchstart', function (event) {
                    if (event.touches.length != 1 || ismoveing) return;
                    var t = $(this);
                    $(".scene.page").css('transition-duration', '0s');
                    var pos_s = event.touches[0].pageY, pos_d;
                    var isFirst = t.is('.page1'), isLast = t.is('.page5');
                    t.on('touchmove', touchmove);
                    t.one('touchend', function () {
                        t.off('touchmove', touchmove);
                        $(".scene.page").css('transition-duration', null);
                        if (pos_d) {
                            var show, hide;
                            var _h = h >> 2;
                            if (pos_d < -_h) {//下一页
                                if (!isLast) {
                                    t.css(prev).next(p).css(self).next(p).addClass(s).css(next);
                                    t.prev(p).removeClass('show');
                                    show = t.next(p).get(0).show;
                                    hide = t.get(0).hide;
                                } else {
                                    t.css(self);
                                }
                            } else if (pos_d > _h) {//上一页
                                if (!isFirst) {
                                    t.css(next).prev(p).css(self).prev(p).addClass(s).css(prev);
                                    t.next(p).removeClass(s);
                                    show = t.prev(p).get(0).show;
                                    hide = t.get(0).hide;
                                } else {
                                    t.css(self);
                                }
                            } else {
                                t.css(self);
                                t.next(p).css(next);
                                t.prev(p).css(prev);
                            }
                            pos_d = null;
                            ismoveing = true;
                            setTimeout(function () {
                                ismoveing = false;
                                if (show)show();
                                if (hide)hide();
                            }, ot);
                        }
                    });
                    var islt;
                    function touchmove(event) {
                        if (event.touches.length != 1) return;
                        requestAnimationFrame(function () {
                            if(t.css('transition-duration') != '0s') return;
                            pos_d = event.touches[0].pageY - pos_s;
                            var _islt = pos_d < 0, v;
                            if (isFirst && !_islt) {
                                t.css('bottom', -parseInt((h >> 2) * (1 - (h / (pos_d + h)))) + "px");
                            } else if (isLast && _islt) {
                                t.css('bottom', parseInt((h >> 2) * (1 - (h / (-pos_d + h)))) + "px");
                            } else {
                                t.css('bottom', -pos_d + "px");
                            }
                            _islt ? t.next().css('bottom', -h - pos_d + "px") : t.prev().css('bottom', h - pos_d + "px");
                            if (islt != _islt) {
                                _islt ? t.prev().css(prev) : t.next().css(next);
                                islt = _islt;
                            }
                        })
                    }
                })
            }
        })
    </script>
    <section class="scene load"></section>
    <section class="scene page page1"></section>
    <section class="scene page page2"></section>
    <section class="scene page page3"></section>
    <section class="scene page page4"></section>
    <section class="scene page page5"></section>
    <section class="scene common"></section>
<?php
}else{
?>
    <style>
        body{background:#fff;}
    </style>
    <div style="width:600px;height:600px;background:url(img/code.png);margin:0 auto 0;"></div>
    <?php
}
?>
</body>
</html>
