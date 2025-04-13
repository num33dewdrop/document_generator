<?php

namespace App\Models;

use App\Database\Connection;
use PDOStatement;

class User extends Model {
	public function findById(int $id): array {
		$sql = "SELECT
					u.id,
					u.google_id,
					u.name,
					u.name_ruby,
					u.birthday,
					u.sex,
					u.dependents,
					u.partner,
					u.partner_support,
					u.fixed_phone,
					u.mobile_phone,
					u.contact_phone,
					u.email,
					u.contact_email,
					u.zip,
					u.prefectures_id,
					p.name AS prefecture,
					u.city_town_village,
					u.address_ruby,
					u.contact_zip,
					u.contact_prefectures_id,
					p2.name AS contact_prefecture,
					u.contact_city_town_village,
					u.contact_address_ruby,
					u.word,
					u.excel,
					u.power_point,
					u.pic
				FROM users AS u
				LEFT JOIN prefectures p on p.id = u.prefectures_id
				LEFT JOIN prefectures p2 on p2.id = u.contact_prefectures_id
				WHERE u.id = :id
				AND u.delete_flg = 0";
		return Connection::fetchAssoc($sql, [':id' => $id]);
	}

	public function findByGoogleClient(string $google_id): array {
		$sql = "SELECT * FROM users
				WHERE google_id = :google_id
				AND delete_flg = 0";
		return Connection::fetchAssoc($sql, [':google_id' => $google_id]);
	}

	public function findByWithdrawnUser(string $google_id): array {
		$sql = "SELECT * FROM users
				WHERE google_id = :google_id
				AND delete_flg = 1";
		return Connection::fetchAssoc($sql, [':google_id' => $google_id]);
	}

	public function findByEmail(string $email): array {
		$sql = "SELECT * FROM users
				WHERE email = :email
				AND delete_flg = 0";
		return Connection::fetchAssoc($sql, [':email' => $email]);
	}

	public function create(array $posts): void {
		$sql  = "INSERT INTO users (
					google_id,
					name,
					email,
					create_at
				)
				VALUES (
					:google_id,
					:name,
					:email,
					:create_at
				)";
		$data = [
			':name'      => $posts['name'],
			':email'     => $posts['email'],
			':google_id' => $posts['google_id'],
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
			':name'                      => $posts['name'],
			':name_ruby'                 => $posts['name_ruby'],
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

	public function delete() {
		$sql = "UPDATE users
				SET delete_flg = 1
				WHERE id = :user_id
				AND delete_flg = 0";
		$data = [
			':user_id' => session()->get('user_id')
		];
		Connection::query($sql, $data);
	}
}