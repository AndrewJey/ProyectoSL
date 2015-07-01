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
            <div class="panel-heading">Your Songs</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <a href="./songs/create" class="btn btn-success">Add Song</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Author</th>
                                    <th>Gender</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($songs as $song) {
                                    echo '<tr>';
                                    echo '<td>'
                                    . ' <a class="btn btn-default"> <span class="glyphicon glyphicon-play-circle" aria-hidden="true"></span> </a>'
                                    . '<audio controls>
                                        <source src="/ProyectoSL/public/songs/getSong/'. $song->id .'" type="audio/mp3">
                                        Not work
                                    </audio>'        
                                    . '</td>';
                                    echo '<td>' . $song->name . '</td>';
                                    echo '<td>' . $song->author . '</td>';
                                    echo '<td>' . $song->gender . '</td>';

                                    echo '<td>' .
                                    '<a href="./songs/edit/' . $song->id . '"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a> | ' .
                                    '<a href="./songs/delete/' . $song->id . '"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a> | '
                                    . '</td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
@stop