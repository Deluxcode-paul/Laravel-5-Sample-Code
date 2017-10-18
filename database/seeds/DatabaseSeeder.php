<?php

use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(StatesTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(PermissionRolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ArticlesTableSeeder::class);
        $this->call(PreferencesTableSeeder::class);
        $this->call(AllergensTableSeeder::class);
        $this->call(HolidaysTableSeeder::class);
        $this->call(DietsTableSeeder::class);
        $this->call(CuisinesTableSeeder::class);
        $this->call(BlessingTypesTableSeeder::class);
        $this->call(SourcesTableSeeder::class);
        $this->call(IngredientsTableSeeder::class);
        $this->call(RecipeCategoriesTableSeeder::class);
        $this->call(CallToActionsTableSeeder::class);
        $this->call(ContactFormSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(VideoIdSeeder::class);
        $this->call(VideoTitleSeeder::class);
        $this->call(ArticleSlugSeeder::class);
        $this->call(RecipeSlugSeeder::class);
    }
}
