<?php
    namespace SlackScore;
    
    use SlackScore\Utils\Command;
    use SlackScore\Utils\Comeback;
    use SlackScore\Models\Request;
    use SlackScore\Utils\SlackPost;
    use SlackScore\Utils\ScoreBoard;
    use SlackScore\Repository\IUserRepository;
    use SlackScore\Repository\SlackUserRepository;

    
    class Main {
        protected $command;
        protected $repository;
        protected $request;
        protected $slackPost;
        protected $comeback;
        protected $token;
        protected $slackUserRepository;
        
        function __construct($token, Request $request, Command $command, Comeback $comeback, IUserRepository $repository, SlackPost $slackPost, SlackUserRepository $slackUserRepository) {
            $this->request = $request;
            $this->command = $command;
            $this->comeback = $comeback;
            $this->repository = $repository;
            $this->slackPost = $slackPost;
            $this->token = $token;
            $this->slackUserRepository = $slackUserRepository;
        }
        
        
        public function handle() {
            if($this->token && $this->request->token !== $this->token) {
                echo 'Not allowed';
                die();
            }
            
            if($this->request->text === 'list') {
                echo ScoreBoard::render($this->repository->getUsers());
                die();
            }
            
            if(!$this->command->isValidCommand()) {
                echo 'Invalid command';
                die();
            }
            
            $fromUser = $this->repository->getByName($this->command->fromUserName());
            $toUser = $this->repository->getByName($this->command->toUserName());
            $scoreChange = $this->command->scoreChange();
            
            // Check if user exists, if repository hasn't loaded, default to true (so you can add users)
            $userExistsInSlack = ($this->slackUserRepository->hasLoaded() ? $this->slackUserRepository->getByName($this->command->toUserName()) : true);
            
            if($fromUser === $toUser) {
                echo "You can't modify your own score, silly.";
                return;
            }
            
            if(!$scoreChange) {
                echo "The score hasn't changed";
                return;
            }
            
            if($toUser) {
                $toUser->modifyScore($scoreChange);
            } else if($userExistsInSlack) {
                $this->repository->addUser($this->command->toUserName(), [], 0 + $scoreChange);
            } else {
                echo "Can't add score to a non-existing user.";
                return;
            }
            
            $this->repository->save();
            
            $this->slackPost->post($this->comeback->render());
        }
    }
    

?>