<?php
    namespace SlackScore;
    
    use SlackScore\Utils\Command;
    use SlackScore\Utils\Comeback;
    use SlackScore\Utils\SlackPost;
    use SlackScore\Repository\IUserRepository;

    
    class Main {
        protected $command;
        protected $repository;
        protected $slackPost;
        protected $comeback;
        
        function __construct(Command $command, Comeback $comeback, IUserRepository $repository, SlackPost $slackPost) {
            $this->command = $command;
            $this->comeback = $comeback;
            $this->repository = $repository;
            $this->slackPost = $slackPost;
        }
        
        
        public function handle() {
            if(!$this->command->isValidCommand()) {
                echo 'Invalid command';
                die();
            }
            
            $fromUser = $this->repository->getByName($this->command->fromUserName());
            $toUser = $this->repository->getByName($this->command->toUserName());
            $scoreChange = $this->command->scoreChange();
            
            if($fromUser === $toUser) {
                echo 'Same user, nope.';
                return;
            }
            
            if(!$scoreChange) {
                echo 'No score lol.';
                return;
            }
            
            if($toUser) {
                $toUser->modifyScore($scoreChange);
            } else {
                $this->repository->addUser($this->command->toUserName(), [], 0 + $scoreChange);
            }
            
            $this->repository->save();
            
            $this->slackPost->post($this->comeback->render(), $this->command->getChannel());
        }
    }
    

?>