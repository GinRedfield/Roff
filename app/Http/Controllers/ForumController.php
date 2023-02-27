<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forum;


class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $forums = Forum::all();
        // return ($forums);
        return view('forum')->with('forums',$forums);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('new_forum_post');
    }

    /**
     * View forums data with sort by views desc function.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function indexView(Request $request)
    {
        $forums = Forum::all();
        $sort = $request->input('sort');
        if($sort == '1'){
            $forumsDesc = $forums->toArray();
            // usort($forumsDesc, function($a, $b)
            // {
            //     return strcmp($a['views'], $b['views']);
            // });
            usort($forumsDesc, function($a, $b) {
                return $b['views'] <=> $a['views'];
            });
            // return ($test);
            return view('forum')->with('forums',$forumsDesc);
        }
        else{
            return view('forum')->with('forums',$forums);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newForum = new Forum();
        $newForum->heading = $request->input('heading');
        $newForum->content = $request->input('content');
        $newForum->views = 0;
        $newForum->create_by = $request->input('create_by');
        $newForum->username = $request->input('username');

        $newForum->save();
        return redirect()->route('forums.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        $forum = Forum::findorFail($id);
        $forum->views += 1;
        $forum->save();
        return view('post')->with('forum', $forum);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Forum::destroy($id);
        return redirect()->route('forums.index');
    }
}
