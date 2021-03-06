<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
@extends('master')

@section('content')
<div class='row'>
    <div class="col-md-12">
        <div class='panel panel-primary'>
            <div class="panel-heading">Edit Playlist</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <a href="/ProyectoSL/public/playlist" class="btn btn-success">Go Back</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php
                                echo Form::open(array('url' => 'playlist/editPost'));
                                echo Form::hidden('playlist_id', $playlist->id);
                        ?>

                            <div class="form-group">
                                <?php
                                echo Form::label('name', 'Nombre');
                                echo Form::text('name', $playlist->name, array('class' => 'form-control', 'placeholder' => 'Name'));
                                ?>
                            </div>

                            <button type="submit" class="btn btn-default">Edit</button>    
                          <?php   Form::close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
@stop