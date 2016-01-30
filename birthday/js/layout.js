var Layout;
(function($){
    Layout = {
        'init': function (scenes, option) {
            $.extend(Layout, {'loading': null, 'loaded': null}, option);
            Layout.LO = {
                'tag': 'div',
                'x': 0,
                'y': 0,
                'w': 0,
                'h': 0,
                'attr': null,
                'css': null,
                'ele': null,
                'isbg': false,
                'isFixed': false
            };
            Layout.SO = {
                'ele': '', /*绑定场景元素*/
                'path': '', /*场景图片根目录*/
                'debug': false, /*是否开启调试模式*/
                'width': 1080, /*场景的宽*/
                'height': 1920, /*场景的高*/
                'scaleW': true, /*是否使宽度固定为屏幕宽度*/
                'scaleH': true, /*是否使高度固定为屏幕高度*/
                'layers': [], /*场景的图层数据*/
                'init': null, /*场景初始化函数*/
                'show': function () {
                    this.ele.show();
                    if (this.afterShow)this.afterShow();
                },
                'afterShow': null,
                'beforeHide': null,
                'hide': function () {
                    if (this.beforeHide)this.beforeHide()
                    this.ele.hide();
                },
            };
            var loadNum = 0, loadSum = 0;
            for (var i in scenes) {
                var scene = new Layout.Scene(scenes[i]);
                loadSum += scene.layers.length;
                scene.create(function () {
                    loadNum++;
                    if (Layout.loading)Layout.loading(loadNum, loadSum);
                    if (loadSum == loadNum && Layout.loaded) Layout.loaded();
                });
            }
        },
        'initPrefix': function () {
            var u = navigator.userAgent;
            Layout.P = u.indexOf("Opera") > -1 ? 'o' :
                u.indexOf("Firefox") > -1 ? 'moz' :
                    u.indexOf("Chrome") > -1 ? 'webkit' :
                        u.indexOf("Safari") > -1 ? 'webkit' :
                            u.indexOf("AppleWebKit") > -1 ? 'webkit' :
                                (u.indexOf("compatible") > -1 && u.indexOf("MSIE") > -1) ? 'ms' : '';
            Layout._P = Layout.P ? '-' + Layout.P + '-' : '';
        },
        'Box': $(window),
        'size': function (k) {
            if (k == 'h')  return Layout.Box.height();
            else if (k == 'w') return Layout.Box.width();
            else  return {h: Layout.Box.height(), w: Layout.Box.width()};
        }
    }
    Layout.initPrefix();
    Layout.Layer = function (layer) {
        layer = $.extend({}, Layout.LO, layer);
        layer.ele = $('<' + layer.tag + '/>').attr(layer.attr).addClass('layer').css(layer.css);
        layer.drawImg = function (path, loadCallback) {
            if (layer.img) {
                var img = new Image();
                img.src = path + layer.img;
                img.onload = function () {
                    if (!layer.w) layer.w = img.width;
                    if (!layer.h) layer.h = img.height;
                    layer.ele.css({'background-image': 'url(' + path + layer.img + ')'});
                    loadCallback(true);
                    if(layer.resize)layer.resize()
                }
            } else {
                loadCallback(false);
                if(layer.resize)layer.resize()
            }
        }
        layer.autoSize = function (style) {
            layer.style = style;
            layer.resize = function () {
                layer.ele.css({
                    'left': layer.x * style.sw + style.ox, 'top': layer.y * style.sh + style.oy,
                    'width': layer.w * style.sw, 'height': layer.h * style.sh
                });
            }
        }
        return layer;
    }
    Layout.Scene = function(scene) {
        scene = $.extend({}, Layout.SO, scene);
        var style = new Layout.Style(), bg_style = new Layout.Style(),a = function () {};
        if (scene.debug) {
            Layout.DEBUG.initScene(scene);
        } else if (scene.scaleH && scene.scaleW) {
            a = function () {
                var size = Layout.size();
                var sw = (size.w / scene.width).toFixed(3);
                var sh = (size.h / scene.height).toFixed(3);
                if (sw > sh) {
                    var tmp = (sw - sh) / 2;
                    style.set(sh, sh, tmp * scene.width, 0);
                    bg_style.set(sw, sw, 0, -tmp * scene.height);
                } else {
                    var tmp = (sh - sw) / 2;
                    style.set(sw, sw, 0, tmp * scene.height);
                    bg_style.set(sh, sh, -tmp * scene.width, 0);
                }
            }
        } else if (scene.scaleW) {
            a = function (size) {
                var s = (Layout.size('w') / scene.width).toFixed(3);
                style.set(s, s);
                bg_style.set(s, s);
            }
        } else if (scene.scaleH) {
            a = function (size) {
                var s = (Layout.size('h') / scene.height).toFixed(3);
                style.set(s, s);
                bg_style.set(s, s);
            }
        }
        scene.resize = function () {
            a();
            for (var i = 0; i < scene.layers.length; i++) {
                var fn = scene.layers[i].resize;
                if (fn)fn();
            }
        }
        scene.create = function (lcb) {
            //Layout.Box.resize(scene.resize);
            scene.resize();
            var loadNum = 0;
            if ((!scene.layers || !scene.layers.length) && scene.init)scene.init();
            else for (var i = 0, loadSum = scene.layers.length; i < loadSum; i++) {
                var layer = new Layout.Layer(scene.layers[i]);
                if (!layer.isFixed) layer.autoSize(layer.isbg ? bg_style : style);
                layer.drawImg(scene.path, function () {
                    loadNum++;
                    if (loadSum == loadNum && scene.init) scene.init();
                    lcb();
                });
                scene.ele.append(layer.ele);
                scene.layers[i] = layer;
                if (scene.debug) Layout.DEBUG.initLayer(layer);
            }
        }
        return scene;
    }
    Layout.Style = function(sw,sh,ox,oy) {
        var style = {sw: sw || 1, sh: sh || 1, ox: ox || 0, oy: oy || 0};
        style.set = function (sw, sh, ox, oy) {
            style.sw = sw || 1, style.sh = sh || 1, style.ox = ox || 0, style.oy = oy || 0;
        }
        return style;
    }
    /*以下是调试代码，可移除*/
    Layout.DEBUG = {
        initLayer: function (l) {
            if (l.isbg) {
                l.ele.mousedown(function () {
                    console.log(l.img + "是背景图片，无法在调试模式下移动！");
                });
                return;
            }
            var startPos, z_index = 99999999;
            l.ele.mousedown(function (event) {
                startPos = {x: l.x - event.pageX, y: l.y - event.pageY};
                $('body').addClass('DOWN').mousemove(mousemove).one('mouseup', mouseup);
                l.ele.addClass('moving');
            });
            l.ele.css('z-index', z_index).dblclick(function () {
                l.ele.css('z-index', --z_index)
            })
            function mousemove(event) {
                event.preventDefault();
                l.x = event.pageX + startPos.x;
                l.y = event.pageY + startPos.y;
                l.ele.css({'left': l.x, 'top': l.y})
            }

            function mouseup(event) {
                event.preventDefault();
                l.ele.removeClass('moving');
                $('body').removeClass('DOWN').off('mousemove', mousemove);
            }
        },
        initScene: function (s) {
            if (!Layout.DEBUG.Enable) {
                var posBox = $("<div class='pos_box'></div>");
                $('body').addClass('DEBUG').append(posBox).mousemove(function (e) {
                        posBox.css({
                            'left': e.pageX + 10,
                            'top': e.pageY + 10
                        }).html('x:' + e.pageX + '<br>' + 'y:' + e.pageY);
                    }
                );
                Layout.DEBUG.Enable = true;
            }
            s.ele.addClass('DEBUG');
            var btn = $('<button class="auto_create_btn" title="这是场景：' + s.ele.selector + ' 的生成代码的按钮">生成代码</button>');
            btn.on('click', function () {
                var ls = '\n';
                for (var j = 0; j < s.layers.length; j++) {
                    var l = {};
                    if (s.layers[j].img) l.img = s.layers[j].img;
                    if (s.layers[j].tag && s.layers[j].tag != 'div') l.tag = s.layers[j].tag;
                    l.x = parseInt(s.layers[j].ele.css('left'));
                    l.y = parseInt(s.layers[j].ele.css('top'));
                    if (s.layers[j].w) l.w = parseInt(s.layers[j].ele.css('width'));
                    if (s.layers[j].h) l.h = parseInt(s.layers[j].ele.css('height'));
                    if (s.layers[j].attr) {
                        l.attr = s.layers[j].attr;
                        if (l.attr.class)l.attr.class = l.attr.class.replace(' layer', '');
                    }
                    if (s.layers[j].css) l.css = s.layers[j].css;
                    if (s.layers[j].isbg) l.isbg = true;
                    ls += JSON.stringify(l) + ',\n';
                }
                console.log(ls);
            })
            $('body').append(btn);
            $('html,body').css('overflow', 'scroll');
        },
        Enable: false,
    }
})(Zepto)