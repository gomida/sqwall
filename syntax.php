<?php
if(!defined('DOKU_INC')) die();

class syntax_plugin_sqwall extends DokuWiki_Syntax_Plugin {

    public function getType(){ return 'formatting'; }
    public function getSort(){ return 158; }
    public function connectTo($mode) { $this->Lexer->addEntryPattern('<sqwall.*?>',$mode,'plugin_sqwall'); }
    public function postConnect() { $this->Lexer->addExitPattern('</sqwall>','plugin_sqwall'); }

    public function handle($match, $state, $pos, Doku_Handler $handler){
        switch ($state) {
            case DOKU_LEXER_ENTER :
            case DOKU_LEXER_UNMATCHED :
                return array($state, $match);
            case DOKU_LEXER_EXIT :
                return array($state, '');
        }
        return array();
    }

    public function render($mode, Doku_Renderer $renderer, $data) {
        if($mode != 'xhtml')
            return false;
        
        list($state,$match) = $data;
        switch ($state) {
            case DOKU_LEXER_ENTER :
                {
/*
                    $m = substr($match,7,1);
                    if($m == "w"){
                    $id = substr($match,8,-1);
                    $file = wikiFN($id);
                        if(file_exists($file)) {
                            $fp = fopen($file, "r");
                            $fr = fread($fp, 4096);
                            fclose($fp);
                            if(preg_match('/<sq (.*)>(.*)<\/sq>/',$fr,$match)){
                            $renderer->doc .= '<div style="position:relative;float:left;width:100%;max-width:720px;margin-bottom:1px;">';
                            $renderer->doc .= '<a href="'.wl($id).'">';
                            $renderer->doc .= '<img style="" src="'.ml($match[1],"w=1440,h=720").'" title="'.p_get_first_heading($id).'">';
                            $renderer->doc .= '<div style="height:100%;width:100%;"><div class="sqwall_title_text">'.p_get_first_heading($id).'</div></div>';
                            $renderer->doc .= '</a>';
                            $renderer->doc .= '</div>';
                            }
                        }
                        break;
                    }
*/
                    $id = substr($match,8,-1);
                    $file = wikiFN($id);
                    if(file_exists($file)) {
                        $fp = fopen($file, "r");
                        $fr = fread($fp, 4096);
                        fclose($fp);
                        if(preg_match('/<sq (.*)>(.*)<\/sq>/',$fr,$match)){
                        $renderer->doc .= '<div class="sqwall_box">';
                        $renderer->doc .= '<a href="'.wl($id).'">';
                        $renderer->doc .= '<img style="position:absolute;top:0;left:0;" src="'.ml($match[1],'w=360,h=360').'" title="'.p_get_first_heading($id).'">';
                        $renderer->doc .= '<div class="sqwall_title_box"><div class="sqwall_title_text">'.p_get_first_heading($id).'</div></div>';
                        $renderer->doc .= '</a>';
                        $renderer->doc .= '</div>';
                        } else {
                        $renderer->doc .= '<div class="sqwall_box">';
                        $renderer->doc .= '<a href="'.wl($id).'">';
                        $renderer->doc .= '<div class="sqwall_title_box" style="visibility:visible;background-color:rgba(0,0,0,0.3);"><div class="sqwall_title_text">'.p_get_first_heading($id).'</div></div>';
                        $renderer->doc .= '</a>';
                        $renderer->doc .= '</div>';
                        }
                    }

                }
                break;
            case DOKU_LEXER_UNMATCHED :
                break;
            case DOKU_LEXER_EXIT :
                break;
        }
        return true;
    }
}

