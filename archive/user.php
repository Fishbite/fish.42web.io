<?php 
require_once 'utils.php';

#### A Practical User Class:
class User
{
        public $id;
        public $username;
        public $email;

        public function __construct(int $id, string $username, string $email) {
                $this->id = $id;
                $this->username = $username;
                $this->email = $email;
        }
}

$users = [
      new User(1, 'Jo', 'jo@email.com'),
      new User(2, 'Jane', 'jane@email.com'),
      new User(3, 'John', 'john@mail.com')
];

$usernames = array_map(
        fn ($user) => [$user->id, $user->username, $user->email],
        $users
);

?>