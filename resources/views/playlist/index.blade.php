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
            <div class="panel-heading">Your Playlist</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <a href="./playlist/create" class="btn btn-success">New Playlist</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($userPlaylists as $playlist) {
                                    echo '<tr>';
                                    echo '<td> <a class="btn btn-default"> <span class="glyphicon glyphicon-play-circle" aria-hidden="true"></span> </a></td>';
                                    echo '<td>' . $playlist->name . '</td>';

                                    echo '<td>' .
                                    '<a href="./playlist/edit/' . $playlist->id . '"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a> | ' .
                                    '<a href="./playlist/delete/' . $playlist->id . '"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a> | ' .
                                    '<a href="./playlist/ManageSongs/' . $playlist->id . '"><span class="glyphicon glyphicon-music" aria-hidden="true"></span></a>'
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