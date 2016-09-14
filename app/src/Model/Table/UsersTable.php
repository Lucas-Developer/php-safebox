<?php

namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 */
class UsersTable extends Table {

  /**
   * Initialize method
   *
   * @param array $config The configuration for the Table.
   * @return void
   */
  public function initialize(array $config) {
    parent::initialize($config);

    $this->table('users');
    $this->displayField('name');
    $this->primaryKey('id');

    $this->addBehavior('Timestamp');
  }

  /**
   * Default validation rules.
   *
   * @param \Cake\Validation\Validator $validator Validator instance.
   * @return \Cake\Validation\Validator
   */
  public function validationDefault(Validator $validator) {
    $validator
        ->integer('id')
        ->allowEmpty('id', 'create');

    $validator
        ->allowEmpty('name');

    $validator
        ->email('email')
        ->requirePresence('email', 'create')
        ->notEmpty('email')
        ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

    $validator
        ->requirePresence('username', 'create')
        ->notEmpty('username')
        ->add('username', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

    $validator
        ->allowEmpty('password');

    $validator
        ->integer('tipo')
        ->allowEmpty('tipo');

    $validator
        ->integer('stat')
        ->allowEmpty('stat');

    return $validator;
  }

  /**
   * Returns a rules checker object that will be used for validating
   * application integrity.
   *
   * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
   * @return \Cake\ORM\RulesChecker
   */
  public function buildRules(RulesChecker $rules) {
    $rules->add($rules->isUnique(['email']));
    $rules->add($rules->isUnique(['username']));
    return $rules;
  }
  
  public function findClientes() {
    $where = "tipo = 2";
    return $this->find('All')->where($where);
  }
  
  public function findMediadores() {
    $where = "tipo = 1";
    return $this->find('All')->where($where);
  }

}
