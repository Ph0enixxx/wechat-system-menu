<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN" ng-app="weixin_menu">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>自定义菜单</title>
    <link href="/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Public/css/index.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body ng-controller="menu">
<nav class="navbar navbar-default">
    <div class="container">
        <a class="navbar-brand" href="index.html">自定义菜单</a>
        <button type="button" class="btn btn-default btn-right" ng-click="sortable=true;" ng-show="!sortable">排序</button>
        <button type="button" class="btn btn-default btn-right" ng-click="cancelSort()" ng-show="sortable">取消</button>
        <button type="button" class="btn btn-default btn-right" ng-click="add()" ng-show="!sortable">新增</button>
        <button type="button" class="btn btn-default btn-right" ng-click="sort()" ng-show="sortable">完成</button>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-7">
            <div>
                可创建最多 3 个一级菜单，每个一级菜单下可创建最多 5 个二级菜单。编辑中的菜单不会马上被用户看到，请放心调试。
            </div>
            <ul class="list-group" ng-show="!sortable">
                <li class="list-group-item" ng-repeat="list in lists">
                    <span class="glyphicon glyphicon-triangle-bottom icon-head" ng-if="list.rank==1"></span>
                        <span class="menu-{{list.rank}}">
                            <span class="glyphicon glyphicon-plus" ng-if="list.rank==3"></span>
                            <span class="pointer" ng-bind="list.name" ng-show="!checked[list.cnt]" ng-click="edit(list.cnt)"></span>
                            <input class="my-input input-{{list.cnt}}" ng-class="{'has-error':has_error && checked[list.cnt]}" ng-model="list.name" type="text" ng-keyup="myKeyup($event, list.cnt);" ng-blur="myBlur(list.cnt)" ng-show="checked[list.cnt]">
                            <span class="glyphicon glyphicon-pencil clarity" ng-if="list.rank!=3" ng-click="edit(list.cnt)"></span>
                            <span class="custom_menu_notice hidden-xs" ng-if="list.rank==1" ng-show="has_error && checked[list.cnt]">
                                一级菜单名称不多于4个汉字或8个字母
                            </span>
                            <span class="custom_menu_notice hidden-xs" ng-if="list.rank==2" ng-show="has_error && checked[list.cnt]">
                                二级菜单名称不多于8个汉字或16个字母
                            </span>
                            <span class="glyphicon glyphicon-trash clarity trash" ng-if="list.rank!=3" ng-click="del(list.cnt)"></span>
                            <span class="label label-default trash" ng-if="list.type" ng-bind="typeArray[list.type]" ng-click="select(list.cnt, list.type)"></span>
                            <select class="my-select" ng-if="list.unselect" ng-change="select(list.cnt ,x)" ng-model="x">
                                <option ng-repeat="(k,v) in typeArray" ng-bind="v" value="{{k}}"></option>
                            </select>
                        </span>
                </li>
            </ul>

            <ul class="dd dd-list" ng-show="sortable">
                <li class="dd-item" ng-repeat="list in lists" ng-if="list.rank==1">
                    <div class="dd-handle" data-id="{{list.cnt}}">
                        <span class="glyphicon glyphicon-triangle-bottom icon-head"></span>
                        <span class="" ng-bind="list.name"></span>
                        <span class="glyphicon glyphicon-menu-hamburger sort"></span>
                    </div>
                    <ul class="dd-list">
                        <li class="dd-item" ng-repeat="item in lists" ng-if="item.rank ==2 && list.position==item.position">
                            <div class="dd-handle" data-id="{{item.cnt}}">
                                <span class="dd-two" ng-bind="item.name"></span>
                                <span class="glyphicon glyphicon-menu-hamburger sort"></span>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
            <button type="button" class="btn btn-primary" ng-click="save()" ng-show="!sortable">发布</button>
           <!-- <button type="button" class="btn btn-primary" ng-click="publish()" ng-show="!sortable">发布</button>-->
            <span class="float-right" ng-show="!sortable">发布后24小时内所有用户都将更新到新的菜单</span>
        </div>

        <div class="col-xs-12 col-sm-5 hidden-xs">
            <div class="preview">
                <div class="center preview-title">预览</div>
                <div class="preview-menu">
                    <div ng-repeat="list in lists" ng-if="list.rank==1">
                        <div class="preview-menu-one preview-menu-has-{{menuCnt}}" ng-click="menuClick(list.position);">
                            <span class="glyphicon glyphicon-menu-hamburger" ng-if="lists[$index+1] && lists[$index+1].rank==2"></span>
                            <span ng-bind="list.name"></span>
                        </div>
                        <div class="preview-menu-two preview-menu-float-{{menuCnt}}-{{list.position+1}}" ng-if="lists[$index+1] && lists[$index+1].rank==2" ng-show="menuShow[list.position]">
                            <span class="preview-menu-click" ng-repeat="item in lists" ng-if="item.rank==2 && list.position==item.position" ng-bind="item.name"></span>
                                <span class="custom_menu_arrow">
                                    <span class="custom_menu_down"></span>
                                    <span class="custom_menu_up"></span>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- .container -->

<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel" ng-bind="editting.title">设置菜单KEY值</h4>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control" id="myModalInput" ng-class="{'has-error':modalError}" ng-keyup="modalKeyup($event);" ng-model="editting.key">
                    <span class="form_info_block" ng-show="modalError">
                        <label class="error">必须填写</label>
                    </span>
                <p class="node" ng-bind="editting.note">菜单KEY值，用于消息接口推送，不超过64个字</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" ng-click="modalFinish();">
                    完成
                </button>
                <button type="button" class="btn btn-default" ng-click="modalCancel();">
                    取消
                </button>
            </div>
        </div>
    </div>
</div>

</body>
<script src="/Public/js/jquery.min.js"></script>
<script src="/Public/bootstrap/js/bootstrap.min.js"></script>
<script src="/Public/js/jquery-ui.min.js"></script>
<script src="/Public/js/angular.min.js"></script>
<script src="/Public/js/index.js"></script>
</html>