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
                        <a href="/ProyectoSL/public/playlist" class="btn btn-success">Go Back</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php
                                echo Form::open(array('url' => 'playlist/saveSongs'));
                                echo Form::hidden('playlist_id', $playlist_id);
                        ?>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($user_songs as $song) {
                                    
                                    $cheked = FALSE;
                                            
                                    foreach ($playlist_songs as $pl_song) {
                                        
                                        if ($pl_song->id_song === $song->id) {
                                            
                                            $cheked = TRUE;
                                        }
                                    }
                                    
                                    echo '<tr>';
                                    echo '<td>'. Form::checkbox('songs[]', $song->id, $cheked) .'</td>';
                                    echo '<td>' . $song->name . '</td>';

                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                          <button type="submit" class="btn btn-default">Save</button>    
                          <?php   Form::close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
@stop