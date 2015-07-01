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
            <div class="panel-heading">Add a new song</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <a href="/ProyectoSL/public/songs" class="btn btn-success">Go Back</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php
                                echo Form::open(array('url' => 'songs/createPost',
                                    'files' => true));
                                
                        ?>

                            <div class="form-group">
                                <?php
                                echo Form::label('name', 'Nombre');
                                echo Form::text('name', '', array('class' => 'form-control', 'placeholder' => 'Name'));
                                ?>
                            </div>
                        
                        <div class="form-group">
                                <?php
                                echo Form::label('author', 'Author');
                                echo Form::text('author', '', array('class' => 'form-control', 'placeholder' => 'Author'));
                                ?>
                            </div>
                        
                        <div class="form-group">
                                <?php
                                echo Form::label('gender', 'Gender');
                                echo Form::text('gender', '', array('class' => 'form-control', 'placeholder' => 'gender'));
                                ?>
                            </div>
                        
                        <div class="form-group">
                                <?php
                                echo Form::label('public', 'Public Access');
                                echo Form::checkbox('public', '');
                                ?>
                            </div>
                        
                        <div class="form-group">
                                <?php
                                echo Form::label('file', 'Music File');
                                echo Form::file('file');
                                ?>
                            </div>

                            <button type="submit" class="btn btn-default">Create</button>    
                          <?php   Form::close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
@stop