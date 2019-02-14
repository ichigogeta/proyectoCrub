@php
    if(!auth()->user()->hasPermission('browse_translations')) {
    die('Acción prohibida detectada');
    }
@endphp

@extends('voyager::master')

@section('javascript')
    @include('vendor.translation-manager.javascript')
@endsection

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css"
          rel="stylesheet"/>

    <style>
        a.status-1 {
            font-weight: bold;
        }
    </style>
@stop

@section('page_title', __('translator.page_title'))

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-documentation"></i>
        {{__('translator.module_title')}}
    </h1>
@stop


@section('content')
    {{--
         <header class="navbar navbar-static-top navbar-inverse" id="top" role="banner">
             <div class="container-fluid">
                 <div class="navbar-header">
                     <button class="navbar-toggle collapsed" type="button" data-toggle="collapse"
                             data-target=".bs-navbar-collapse">
                         <span class="sr-only">Toggle navigation</span>
                         <span class="icon-bar"></span>
                         <span class="icon-bar"></span>
                         <span class="icon-bar"></span>
                     </button>
                      <a href="{{echo action('\Barryvdh\TranslationManager\Controller@getIndex') }}" class="navbar-brand">
                          Translation Manager
                      </a>

                 </div>
             </div>
         </header>
    --}}
    <div class="container-fluid">
        {{__('translator.module_warning')}}
        {{--
        <p>Warning, translations are not visible until they are exported back to the app/lang file, using <code>php
                artisan translation:export</code> command or publish button.</p>
        --}}
        <div class="alert alert-success success-import" style="display:none;">
            <p>{!! __('translator.importing_done') !!}</p>
        </div>
        <div class="alert alert-success success-find" style="display:none;">
            <p>{!! __('translator.search_done') !!}</p>
        </div>
        <div class="alert alert-success success-publish" style="display:none;">
            <p>{!! __('translator.publishing_one_done') !!}'<?php echo $group ?>'!</p>
        </div>
        <div class="alert alert-success success-publish-all" style="display:none;">
            <p>{!! __('translator.publishing_all_done') !!}</p>
        </div>
        <?php if(Session::has('successPublish')) : ?>
        <div class="alert alert-info">
            <?php echo Session::get('successPublish'); ?>
        </div>
        <?php endif; ?>
        <p>
        <?php if(!isset($group)) : ?>
        <form class="form-import" method="POST"
              action="<?php echo action('\Barryvdh\TranslationManager\Controller@postImport') ?>" data-remote="true"
              role="form">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-3">
                        <select name="replace" class="form-control">
                            <option value="0">{{__('translator.append')}}</option>
                            <option value="1">{{__('translator.replace')}}</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-success btn-block" data-disable-with="Loading..">
                            {{__('translator.import_btn')}}
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <form class="form-find" method="POST"
              action="<?php echo action('\Barryvdh\TranslationManager\Controller@postFind') ?>" data-remote="true"
              role="form"
              data-confirm="{{__('translator.find_data_confirm')}}">
            <div class="form-group">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <button type="submit" class="btn btn-info"
                        data-disable-with="Searching..">{{__('translator.find_files_btn')}}
                </button>
            </div>
        </form>
        <?php endif; ?>
        <?php if(isset($group)) : ?>
        <form class="form-inline form-publish" method="POST"
              action="<?php echo action('\Barryvdh\TranslationManager\Controller@postPublish', $group) ?>"
              data-remote="true" role="form"
              data-confirm="{{__('translator.publish_confirm')}}'<?php echo $group ?>? {{__('translator.publish_confirm2')}}">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <button type="submit" class="btn btn-info"
                    data-disable-with="Publishing..">{{__('translator.publish_btn')}}</button>
            <a href="<?= action('\Barryvdh\TranslationManager\Controller@getIndex') ?>"
               class="btn btn-default">{{__('translator.back')}}</a>
        </form>
        <?php endif; ?>
        </p>
        <form role="form" method="POST"
              action="<?php echo action('\Barryvdh\TranslationManager\Controller@postAddGroup') ?>">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="form-group">
                <p>{{__('translator.choose_a_group')}}</p>
                <select name="group" id="group" class="form-control group-select">
                    <?php foreach($groups as $key => $value): ?>
                    <option value="<?php echo $key ?>"<?php echo $key == $group ? ' selected' : '' ?>><?php echo $value ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>{{__('translator.add_a_group')}}</label>
                <input type="text" class="form-control" name="new-group"/>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-default" name="add-group"
                       value="{{__('translator.add_and_edit')}}"/>
            </div>
        </form>
        <?php if($group): ?>
        <form action="<?php echo action('\Barryvdh\TranslationManager\Controller@postAdd', array($group)) ?>"
              method="POST" role="form">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="form-group">
                <label>{{__('translator.add_new_keys')}}</label>
                <textarea class="form-control" rows="3" name="keys"
                          placeholder="{{__('translator.add_new_keys_placeholder')}}"></textarea>
            </div>
            <div class="form-group">
                <input type="submit" value="{{__('translator.add_keys')}}" class="btn btn-primary">
            </div>
        </form>
        <hr>
        <h4>Total: <?= $numTranslations ?>, changed: <?= $numChanged ?></h4>
        <table class="table">
            <thead>
            <tr>
                <th width="15%">Key</th>
                <?php foreach ($locales as $locale): ?>
                <th><?= $locale ?></th>
                <?php endforeach; ?>
                <?php if ($deleteEnabled): ?>
                <th>&nbsp;</th>
                <?php endif; ?>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($translations as $key => $translation): ?>
            <tr id="<?php echo htmlentities($key, ENT_QUOTES, 'UTF-8', false) ?>">
                <td><?php echo htmlentities($key, ENT_QUOTES, 'UTF-8', false) ?></td>
                <?php foreach ($locales as $locale): ?>
                <?php $t = isset($translation[$locale]) ? $translation[$locale] : null ?>

                <td>
                    <a href="#edit"
                       class="editable status-<?php echo $t ? $t->status : 0 ?> locale-<?php echo $locale ?>"
                       data-locale="<?php echo $locale ?>"
                       data-name="<?php echo $locale . "|" . htmlentities($key, ENT_QUOTES, 'UTF-8', false) ?>"
                       id="username" data-type="textarea" data-pk="<?php echo $t ? $t->id : 0 ?>"
                       data-url="<?php echo $editUrl ?>"
                       data-title="{{__('translator.enter_translation')}}"><?php echo $t ? htmlentities($t->value, ENT_QUOTES, 'UTF-8', false) : '' ?></a>
                </td>
                <?php endforeach; ?>
                <?php if ($deleteEnabled): ?>
                <td>
                    <a href="<?php echo action('\Barryvdh\TranslationManager\Controller@postDelete', [$group, $key]) ?>"
                       class="delete-key"
                       data-confirm="{{__('translator.delete_confirm')}}'<?php echo htmlentities($key, ENT_QUOTES, 'UTF-8', false) ?>?"><span
                                class="glyphicon glyphicon-trash"></span></a>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <fieldset>
            <legend>{{__('translator.supported_locales')}}</legend>
            <p>
                {{__('translator.current_supported_locales')}}:
            </p>
            <form class="form-remove-locale" method="POST" role="form"
                  action="<?php echo action('\Barryvdh\TranslationManager\Controller@postRemoveLocale') ?>"
                  data-confirm="Are you sure to remove this locale and all of data?">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <ul class="list-locales">
                    <?php foreach($locales as $locale): ?>
                    <li>
                        <div class="form-group">
                            <button type="submit" name="remove-locale[<?php echo $locale ?>]"
                                    class="btn btn-danger btn-xs" data-disable-with="...">
                                &times;
                            </button>
                            <?php echo $locale ?>

                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </form>
            <form class="form-add-locale" method="POST" role="form"
                  action="<?php echo action('\Barryvdh\TranslationManager\Controller@postAddLocale') ?>">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="form-group">
                    <p>
                        {{__('translator.new_locale_key')}}:
                    </p>
                    <div class="row">
                        <div class="col-sm-3">
                            <input type="text" name="new-locale" class="form-control"/>
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-default btn-block" data-disable-with="Adding..">
                                {{__('translator.add_new_locale')}}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </fieldset>
        <fieldset>
            <legend>{{__('translator.add_new_locale')}}</legend>
            <form class="form-inline form-publish-all" method="POST"
                  action="<?php echo action('\Barryvdh\TranslationManager\Controller@postPublish', '*') ?>"
                  data-remote="true" role="form"
                  data-confirm="{{__('translator.publish_all_confirm')}}">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <button type="submit" class="btn btn-primary"
                        data-disable-with="Publishing..">{{__('translator.publish_all')}}</button>
            </form>
        </fieldset>

        <?php endif; ?>
    </div>
@stop
