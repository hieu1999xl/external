<?php

/**
 * Fieldsetクラスの拡張
 *
 * @author sakairi@liz-inc.co.jp
 *
 */
class Fieldset extends Fuel\Core\Fieldset {

    /**
     * validationの対象が0 , '0' でもフィールド名として登録出来る様に拡張
     *
     * @param string
     * @param string
     * @param array
     * @param array
     * @return Fieldset_Field
     */
    public function add($name, $label = '', array $attributes = [], array $rules = []) {
        if ($name instanceof Fieldset_Field) {
            if ($name->name == '' or $this->field($name->name) !== false) {
                throw new \RuntimeException('Fieldname empty or already exists in this Fieldset: "' . $name->name . '".');
            }

            $name->set_fieldset($this);
            $this->fields[$name->name] = $name;
            return $name;
        } elseif ($name instanceof Fieldset) {
            if (empty($name->name) or $this->field($name->name) !== false) {
                throw new \RuntimeException('Fieldset name empty or already exists in this Fieldset: "' . $name->name .
                    '".');
            }

            $name->set_parent($this);
            $this->fields[$name->name] = $name;
            return $name;
        }

        // ここを0でも許容される様に修正(empty()だと弾かれるため)
        if ($name === false || $name === null || $name === '' || $name === [] ||
            (is_array($name) and empty($name['name']))) {
            throw new \InvalidArgumentException('Cannot create field without name.');
        }

        // Allow passing the whole config in an array, will overwrite other values if that's the case
        if (is_array($name)) {
            $attributes = $name;
            $label = isset($name['label']) ? $name['label'] : '';
            $rules = isset($name['rules']) ? $name['rules'] : [];
            $name = $name['name'];
        }

        // Check if it exists already, if so: return and give notice
        if ($field = $this->field($name)) {
            \Error::notice('Field with this name exists already in this fieldset: "' . $name . '".');
            return $field;
        }

        $this->fields[$name] = new \Fieldset_Field($name, $label, $attributes, $rules, $this);

        return $this->fields[$name];

    }
}
