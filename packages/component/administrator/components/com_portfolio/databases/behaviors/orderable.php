<?php

defined('KOOWA') or die('Protected resource');

class ComPortfolioDatabaseBehaviorOrderable extends KDatabaseBehaviorOrderable
{

    public function order($change)
    {
        $iso_code   = substr(JFactory::getLanguage()->getTag(), 0, 2);
        //force to integer
        settype($change, 'int');

        if($change !== 0)
        {
            $old = (int) $this->ordering;
            $new = $this->ordering + $change;
            $new = $new <= 0 ? 1 : $new;

            $table = $this->getTableName($iso_code,$this->getTable());
            $db    = $this->getTable()->getDatabase();
            $query = $db->getQuery();

            //Build the where query
            $this->_buildQueryWhere($query);

            $update =  'UPDATE `'.$db->getTableNeedle().$table.'` ';

            if($change < 0)
            {
                $update .= 'SET ordering = ordering+1 ';
                $query->where('ordering', '>=', $new)
                    ->where('ordering', '<', $old);
            }
            else
            {
                $update .= 'SET ordering = ordering-1 ';
                $query->where('ordering', '>', $old)
                    ->where('ordering', '<=', $new);
            }

            $update .= (string) $query;

            $db->execute($update);

            $this->ordering = $new;
//            $this->save();
//            $this->reorder();
        }

        return $this->_mixer;
    }


    public function getTableName($iso_code, $table)
    {
        $name = $table->getBase();

        if($iso_code != 'en') {
            try {
                if($table->getDatabase()->getTableSchema($iso_code.'_'.$name)) {
                    $name = $iso_code.'_'.$name;
                }
            } catch(Exception $e) {
                //TODO:: Mail error report!
            }
        }

        return $name;
    }
}