<?php

class aRichTextCkeditorSlotActions extends aSlotActions {

  public function executeEdit(sfRequest $request) {
    $this->editSetup();

    // Work around FCK's incompatibility with AJAX and bracketed field names
    // (it insists on making the ID bracketed too which won't work for AJAX)
    // Don't forget, there's a CSRF field out there too. We need to grep through
    // the submitted fields and get all of the relevant ones, reinventing what
    // PHP's bracket syntax would do for us if FCK were compatible with it
    $values = $request->getParameterHolder()->getAll();
    $value = array();
    foreach ($values as $k => $v) {
      if (preg_match('/^slot-form-' . $this->id . '-(.*)$/', $k, $matches)) {
        $value[$matches[1]] = $v;
      }
    }
    
    // Hyphen between slot and form to please our CSS
    $this->form = new aRichTextCkeditorSlotEditForm($this->id, array());
    $this->form->bind($value);
    if ($this->form->isValid()) {
      // Serializes all of the values returned by the form into the 'value' column of the slot.
      // This is only one of many ways to save data in a slot. You can use custom columns,
      // including foreign key relationships (see schema.yml), or save a single text value 
      // directly in 'value'. serialize() and unserialize() are very useful here and much
      // faster than extra columns

      $this->slot->value = $this->form->getValue('value');
      return $this->editSave();
    } else {
      // Makes $this->form available to the next iteration of the
      // edit view so that validation errors can be seen, if any
      return $this->editRetry();
    }
  }

}

