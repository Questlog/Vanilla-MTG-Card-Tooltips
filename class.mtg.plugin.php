<?php if (!defined('APPLICATION')) exit();

$PluginInfo['MTG'] = array(
   'Name' => 'MTG',
   'Description' => "Adds MTG BBcode.",
   'Version' => '0.1',
   'MobileFriendly' => TRUE,
   'Author' => "Questlog",
   'AuthorEmail' => 'questlog@github.com',
   'AuthorUrl' => 'http://github.com/questlog'
);

use Nbbc\BBCode as BBCode;

class SpoilersPlugin extends Gdn_Plugin {

    public function bbcode_afterBBCodeSetup_handler($Sender) {
        $nbbc = $Sender->EventArguments['BBCode'];

        $nbbc->addRule('mtg', [
            'mode' => BBCode::BBCODE_MODE_CALLBACK,
            'method' => [$this, 'doCard'],
            'allow_in' => ['listitem', 'block', 'columns', 'inline'],
            'content' => BBCode::BBCODE_REQUIRED
        ]);
    }
   
    public function doCard(BBCode $bbcode, $action, $name, $default, $params, $content) {
        
        return "<a href=\"https://deckbox.org/mtg/". htmlspecialchars($content) ."\">" . htmlspecialchars($content) . "</a>";
    }
   
      
    public function DiscussionController_Render_Before(&$Sender) {
        $this->PrepareController($Sender);
    }

    public function PostController_Render_Before(&$Sender) {
        $this->PrepareController($Sender);
    }

    public function MessagesController_Render_Before(&$Sender) {
        $this->PrepareController($Sender);
    }

    protected function PrepareController(&$Sender) {
        $Sender->AddJsFile('tooltip.js', 'plugins/MTG');
    }
   
}
