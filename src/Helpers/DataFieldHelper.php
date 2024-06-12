<?php

namespace iProtek\SysNotification\Helpers; 
use DB;
use iProtek\Data\Models\DataModel;
use iProtek\Data\Models\DataModelField;
use iProtek\Data\Models\DataModelFieldValue;

class DataFieldHelper
{ 
    public static function setFields($fields, ProjectDataModel $id, $parent_id , $user_pay_id ){
    
        //get activated
        $activated_fields = [];
        $count = 1;
        foreach($fields as $field){
            if($field['id'] == 0){
               $item = ProjectDataModelField::create([
                "pay_created_by"=>$user_pay_id,
                "data_model_id"=>$id->id,
                "model_field_id"=>$field['model_field_id'],
                "parent_id"=>$parent_id,
                "order_no"=>$count,
                //"order_id"=>$count,
               ]);

            }
            else{
               //Select specific constraint
               $item = ProjectDataModelField::where('data_model_id', $id->id)->where('model_field_id', $field['model_field_id'])->find($field['id']);
               if(!$item){
                 continue;
               }
               //$item->pay_updated_by = $user_pay_id;
               $item->parent_id = $parent_id;
               //$item->order_id = $count;
               $item->order_no = $count;
               if($item->isDirty()){
                    $item->pay_updated_by = $user_pay_id;
                    $item->save();
               }
            } 
            $activated_fields[] = $item->id;
            if( count($field['fields']) > 0 ){ 
               $sub_activated_fields =  static::setFields($field['fields'], $id, $item->id, $user_pay_id);
               foreach($sub_activated_fields as $subId){
                 $activated_fields[] = $subId;
               }
            }

            $count++;
            
        } 
        return $activated_fields;
    
    
    }

    
    public static function fieldsgetSub($list, $parent_id, $data_id = null){
        $subItems = [];
        foreach( $list as $item ){
            if($item->parent_id == $parent_id ){
                
                $item->fields = static::fieldsgetSub($list, $item->id, $data_id);
                if($data_id){
                    //$item->data_values = static::getFieldValues($data_id, $item->id); 
                    $item->setAttribute('data_values', static::getFieldValues($data_id, $item->id)); 
                }
                $subItems[] = $item;
                
            }
        }

        return $subItems;
    }

    public static function getFieldValues($data_id, $data_model_field_id){
        return ProjectDataModelFieldValue::with(['link_data'])->where('project_data_id', $data_id)->where('data_model_field_id', $data_model_field_id)->orderBy('order_no', 'ASC')->get();
    }

}
