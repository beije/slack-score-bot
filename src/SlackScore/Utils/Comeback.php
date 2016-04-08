<?php
    namespace SlackScore\Utils;
    
    use SlackScore\Utils\Command;
    use SlackScore\Repository\IUserRepository;
    
    class Comeback {
        protected $command;
        protected $phrases;
        protected $repository;
        
        public function __construct($phrases = array(), Command $command, IUserRepository $repository) {
            $this->phrases = $phrases;
            $this->command = $command;
            $this->repository = $repository;
        }

        
        public function render() {
            if($this->command->scoreChange() < 0) {
                $phrase = $this->phrases['negative'][array_rand($this->phrases['negative'])];
            } else {
                $phrase = $this->phrases['positive'][array_rand($this->phrases['positive'])];
            }
            
            $fromUser = $this->repository->getByName($this->command->fromUserName());
            $toUser = $this->repository->getByName($this->command->toUserName());
            $scoreChange = $this->command->scoreChange();
            
            if($this->command->getMessage()) {
                return '@' . $fromUser->name . ': ' . $this->command->getMessage() . ' (@' . $toUser->name . ' ' . $this->command->scoreChange() . ')';
            }
            
            return str_replace(
                [':from', ':to', ':score'],
                ['@' . $fromUser->name, '@' . $toUser->name, $this->command->scoreChange()],
                $phrase
            );
        }
    }