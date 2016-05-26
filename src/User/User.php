<?php

namespace Anax\User;
 
/**
 * Model for Users.
 *
 */
class User extends \Anax\MVC\CDatabaseModel
{
    public static $loginSession = 'User::Login';
    
	public function setup()
	{
		$this->db->dropTableIfExists('user')->execute();
        $this->db->createTable(
            'user',
            [
                'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
                'username' => ['varchar(20)', 'unique', 'not null'],
                'email' => ['varchar(80)'],
                'name' => ['varchar(80)'],
                'password' => ['varchar(255)'],
                'created' => ['datetime'],
                'deleted' => ['datetime'],
            ]
        )->execute();

        $this->db->insert(
            'user',
            ['username', 'email', 'name', 'password', 'created']
        );

        $now = gmdate('Y-m-d H:i:s');

        $options = [
            'cost' => 12,
        ];

        $this->db->execute([
            'admin',
            'admin@dbwebb.se',
            'Administrator',
            password_hash('admin', PASSWORD_BCRYPT, $options),
            $now,
        ]);

        $this->db->execute([
            'doe',
            'doe@dbwebb.se',
            'John/Jane Doe',
            password_hash('doe', PASSWORD_BCRYPT, $options),
            $now,
        ]);

        $this->db->execute([
            'McKnubb',
            'eloliasos@hotmail.com',
            'Elias Tångring',
            password_hash('123qwe', PASSWORD_BCRYPT, $options),
            $now,
        ]);
	}

	public function login($username, $password)
    {
        $this->db->select()
                 ->from($this->getSource())
                 ->where("username = ?");
     
        $this->db->execute([$username]);
        $res = $this->db->fetchInto($this);

        if($res) {
            if(password_verify($password, $res->password)) {
                $this->session->set(self::$loginSession, $res->id);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function logout()
    {
        unset($_SESSION[self::$loginSession]);
    }

    public function getOnlineUser()
    {
        if($this->checkIfLoggedIn()) {
            $id = $this->session->get(self::$loginSession);
            $user = $this->find($id);
            return $user;
        } else {
            return false;
        }
    }

    public function checkIfLoggedIn()
    {
        return $this->session->has(self::$loginSession);
    }
}
