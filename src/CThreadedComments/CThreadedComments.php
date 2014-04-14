<?php

/**
 * A class to output threaded comments
 * 
 * @package MmvcCore
 */
class CThreadedComments {
	
       public $parents  = array();
       public $children = array();
       
       public $sorted = array();

    /**
     * @param array $comments
     */
    function __construct($comments)
    {
        foreach ($comments as $comment)
        {
            if ($comment['parent'] == "")
            {
                $this->parents[$comment['id']][] = $comment;
            }
            else
            {
                $this->children[$comment['parent']][] = $comment;
            }
        }
     /*   $this->print_comments(); */
    }
 
    /**
     * @param array $comment
     * @param int $depth
     */
    private function format_comment($comment, $depth)
    {
    /*    for ($depth; $depth > 0; $depth--)
        { */
            $comment['depth'] = $depth;
      /*  }  */
        $this->sorted[] = $comment;
    }
    
    /**
     * @param array $comment
     * @param int $depth
     */
     
    private function print_parent($comment, $depth = 0)
    {
        foreach ($comment as $c)
        {
           $this->format_comment($c, $depth);
            if (isset($this->children[$c['id']]))
            {
                $this->print_parent($this->children[$c['id']], $depth + 1);
            }
        }
    }
 
    public function print_comments()
    {
        if (isset($this->parents)) {
           foreach ($this->parents as $c)
           {
              $this->print_parent($c);
           }
        }
   /*     else {
           foreach ($this->children as $c) {
              $this->format_coment($c, 0);
           }
        } */
    /*    return $this->sorted; */
    }
 
}

