<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ContactFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedForms();
        $this->seedFields();
        $this->seedOptions();
    }

    /**
     * Seed forms
     */
    protected function seedForms()
    {
        $dateTime = Carbon::now()->toDateTimeString();
        $items = [
            [
                'id' => 1,
                'slug' => 'contact_us',
                'elem_id' => 'contact-us',
                'elem_class' => null,
                'attributes' => null,
                'thank_you_message' => 'Thank you for your submission',
                'thank_you_slug' => null,
                'has_recaptcha' => 0,
                'is_page' => 0,
                'handler_route' => null
            ]
        ];

        if (0 == DB::table('bfm_forms')->count()) {
            foreach ($items as $item) {
                $item['created_at'] = $dateTime;
                $item['updated_at'] = $dateTime;
                DB::table('bfm_forms')->insert($item);
            }
        }
    }

    /**
     * Seed fields
     */
    protected function seedFields()
    {
        $dateTime = Carbon::now()->toDateTimeString();
        $items = [
            [
                'id' => 1,
                'form_id' => 1,
                'parent_id' => null,
                'lft' => null,
                'rgt' => null,
                'depth' => null,
                'wrapper_id' => null,
                'wrapper_class' => null,
                'name' => 'inquiry_type',
                'value' => null,
                'label' => 'TYPE OF INQUIRY',
                'placeholder' => 'Choose One',
                'type' => 'Select',
                'validation_be' => 'required',
                'validation_fe' => null,
                'fieldset' => null,
                'is_required' => 1,
                'is_multiple' => 0,
                'is_get_param' => 1,
                'data_type' => 'varchar',
                'is_shown_in_grid' => 1
            ],
            [
                'id' => 2,
                'form_id' => 1,
                'parent_id' => null,
                'lft' => null,
                'rgt' => null,
                'depth' => null,
                'wrapper_id' => null,
                'wrapper_class' => null,
                'name' => 'full_name',
                'value' => null,
                'label' => 'NAME',
                'placeholder' => 'Your Full Name',
                'type' => 'Text',
                'validation_be' => 'required|max:255',
                'validation_fe' => null,
                'fieldset' => null,
                'is_required' => 1,
                'is_multiple' => 0,
                'is_get_param' => 1,
                'data_type' => 'varchar',
                'is_shown_in_grid' => 1
            ],
            [
                'id' => 3,
                'form_id' => 1,
                'parent_id' => null,
                'lft' => null,
                'rgt' => null,
                'depth' => null,
                'wrapper_id' => null,
                'wrapper_class' => null,
                'name' => 'email',
                'value' => null,
                'label' => 'YOUR EMAIL',
                'placeholder' => 'Enter Your Email',
                'type' => 'Email',
                'validation_be' => 'required|email',
                'validation_fe' => null,
                'fieldset' => null,
                'is_required' => 1,
                'is_multiple' => 0,
                'is_get_param' => 1,
                'data_type' => 'varchar',
                'is_shown_in_grid' => 1
            ],
            [
                'id' => 4,
                'form_id' => 1,
                'parent_id' => null,
                'lft' => null,
                'rgt' => null,
                'depth' => null,
                'wrapper_id' => null,
                'wrapper_class' => null,
                'name' => 'message',
                'value' => null,
                'label' => 'MESSAGE',
                'placeholder' => 'Type Your Message Here',
                'type' => 'Textarea',
                'validation_be' => null,
                'validation_fe' => null,
                'fieldset' => null,
                'is_required' => 0,
                'is_multiple' => 0,
                'is_get_param' => 0,
                'data_type' => 'text',
                'is_shown_in_grid' => 0
            ]
        ];

        if (0 == DB::table('bfm_forms_fields')->count()) {
            foreach ($items as $item) {
                $item['created_at'] = $dateTime;
                $item['updated_at'] = $dateTime;
                DB::table('bfm_forms_fields')->insert($item);
            }
        }
    }

    /**
     * Seed forms
     */
    protected function seedOptions()
    {
        $dateTime = Carbon::now()->toDateTimeString();
        $items = [
            [
                'id' => 1,
                'field_id' => 1,
                'title' => 'Suggest a Recipe',
                'value' => 'Suggest a Recipe',
                'parent_id' => null,
                'lft' => null,
                'rgt' => null,
                'depth' => null
            ],
            [
                'id' => 2,
                'field_id' => 1,
                'title' => 'Claim Profile',
                'value' => 'Claim Profile',
                'parent_id' => null,
                'lft' => null,
                'rgt' => null,
                'depth' => null
            ],
            [
                'id' => 3,
                'field_id' => 1,
                'title' => 'General Support',
                'value' => 'General Support',
                'parent_id' => null,
                'lft' => null,
                'rgt' => null,
                'depth' => null
            ]
        ];

        if (0 == DB::table('bfm_forms_options')->count()) {
            foreach ($items as $item) {
                $item['created_at'] = $dateTime;
                $item['updated_at'] = $dateTime;
                DB::table('bfm_forms_options')->insert($item);
            }
        }
    }
}
