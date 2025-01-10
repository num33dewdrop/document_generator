<?php

namespace Models;

use Database\Connection;
use PDOStatement;

class User extends Model {
	public function findById(int $id): array {
		$sql = "SELECT * FROM users
				WHERE id = :id
				AND delete_flg = 0";
		return Connection::fetchAssoc($sql, [':id' => $id]);
	}

	public function findByEmail(string $email): array {
		$sql = "SELECT * FROM users
				WHERE email = :email";
		return Connection::fetchAssoc($sql, [':email' => $email]);
	}

	public function create(array $posts): void {
		$sql  = "INSERT INTO users (
					name,
					email,
					password,
					create_at
				)
				VALUES (
					:name,
					:email,
					:password,
					:create_at
				)";
		$data = [
			':name'      => $posts['name'],
			':email'     => $posts['email'],
			':password'  => password_hash( $posts['password'], PASSWORD_DEFAULT ),
			':create_at' => date( 'Y-m-d H:i:s' )
		];
		Connection::query( $sql, $data );
	}

	public function update (array $posts): void {
		$sql = "UPDATE users 
				SET name = :name,
				    name_ruby = :name_ruby,
				    birthday = :birthday,
				    sex = :sex,
				    dependents = :dependents,
				    partner = :partner,
				    partner_support = :partner_support,
				    fixed_phone = :fixed_phone,
				    mobile_phone = :mobile_phone,
				    contact_phone = :contact_phone,
				    email = :email,
				    zip = :zip,
				    prefectures_id = :prefectures_id,
				    city_town_village = :city_town_village,
				    contact_zip = :contact_zip,
				    contact_prefectures_id = :contact_prefectures_id,
				    contact_city_town_village = :contact_city_town_village,
				    word = :word,
				    excel = :excel,
				    power_point = :power_point,
				    pic = :pic
				WHERE id = :user_id
				AND delete_flg = 0";
		$data = [
			':user_id'                   => session()->get('user_id'),
			':name'                      => $posts['user_name'],
			':name_ruby'                 => $posts['user_name_ruby'],
			':birthday'                  => $posts['birthday'],
			':sex'                       => $posts['sex'],
			':dependents'                => $posts['dependents'],
			':partner'                   => $posts['partner'],
			':partner_support'           => $posts['partner_support'],
			':fixed_phone'               => $posts['fixed_phone'],
			':mobile_phone'              => $posts['mobile_phone'],
			':contact_phone'             => $posts['contact_phone'],
			':email'                     => $posts['email'],
			':zip'                       => $posts['zip'],
			':prefectures_id'            => $posts['prefectures_id'],
			':city_town_village'         => $posts['city_town_village'],
			':contact_zip'               => $posts['contact_zip'],
			':contact_prefectures_id'    => $posts['contact_prefectures_id'],
			':contact_city_town_village' => $posts['contact_city_town_village'],
			':word'                      => $posts['word'],
			':excel'                     => $posts['excel'],
			':power_point'               => $posts['power_point'],
			':pic'                       => $posts['pic'],
		];
		Connection::query($sql, $data);
	}
}