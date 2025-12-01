<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Location;
use App\Models\Product;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Recipe;
use PHPUnit\Framework\Attributes\Test;

class ModelRelationshipTest extends TestCase
{
    use RefreshDatabase; // Membersihkan database testing

    protected function setUp(): void
    {
        parent::setUp();
        // Pastikan Factories untuk semua model ini sudah ada
        // Category, Unit, Location, User, Product, Recipe
    }

    // ----------------------------------------------------
    // TEST CASE 1: HUBUNGAN DASAR (User -> Location)
    // ----------------------------------------------------

    #[Test]
    public function a_user_belongs_to_a_location()
    {
        // ARRANGE: Buat Location dan User
        $location = Location::factory()->create(['name' => 'Test Outlet']);
        $user = User::factory()->create(['location_id' => $location->id]);

        // ASSERT: Pastikan relasi model Location bekerja
        $this->assertInstanceOf(Location::class, $user->location);
        $this->assertEquals('Test Outlet', $user->location->name);
    }

    // ----------------------------------------------------
    // TEST CASE 2: HUBUNGAN PRODUCT KE CATEGORY (FK Check)
    // ----------------------------------------------------

    #[Test]
    public function a_product_belongs_to_a_category()
    {
        // ARRANGE: Buat Category dan Product
        $category = Category::factory()->create(['name' => 'Minuman Kopi']);
        $product = Product::factory()->create(['category_id' => $category->id]);

        // ASSERT: Pastikan relasi Category bekerja
        $this->assertInstanceOf(Category::class, $product->category);
        $this->assertEquals($category->id, $product->category->id);
    }

    // ----------------------------------------------------
    // TEST CASE 3: F&B CORE (Product Menu -> Recipes)
    // ----------------------------------------------------

    #[Test]
    public function a_menu_product_has_many_recipe_ingredients()
    {
        // ARRANGE: Buat Menu (Product type=menu) dan Ingredients
        $menu = Product::factory()->menu()->create();
        $ingredientKopi = Product::factory()->ingredient()->create(['name' => 'Kopi']);
        $ingredientSusu = Product::factory()->ingredient()->create(['name' => 'Susu']);

        // Buat 2 baris Resep untuk Menu ini
        Recipe::factory()->create([
            'menu_product_id' => $menu->id,
            'ingredient_product_id' => $ingredientKopi->id,
            'quantity_used' => 0.05,
        ]);
        Recipe::factory()->create([
            'menu_product_id' => $menu->id,
            'ingredient_product_id' => $ingredientSusu->id,
            'quantity_used' => 0.10,
        ]);

        // ASSERT: Pastikan relasi recipeIngredients mengembalikan 2 record
        $this->assertCount(2, $menu->recipeIngredients);
        $this->assertInstanceOf(Recipe::class, $menu->recipeIngredients->first());
    }
}