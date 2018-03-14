import {Component, OnInit} from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import {Observable} from 'rxjs/Observable';
import {Ingredient} from '../model/ingredient';
import {RecipeDetail} from '../model/recipe-detail';
import {RecipeState} from '../service/recipe.state';

@Component({
    template: `
        <div *ngIf="recipeObservable|async as recipe"
             class="app-recipe">
            <div class="app-recipe-wrapper">
                <img [src]="getPhotos(recipe)"
                     class="app-recipe-image">

                <div class="app-recipe-content">
                    <h1>{{ recipe.name }}</h1>

                    <app-recipe-facts [recipe]="recipe"
                                      [cssModifier]="['app-recipe-facts--big', 'app-recipe-facts--white']">
                    </app-recipe-facts>

                    <p [innerHTML]="recipe.description"></p>

                    <span class="app-recipe-content_macros">{{ 'app.recipe_detail.nutrition' | appTrans }}</span>

                    <ul class="app-recipe-content_macro-list">
                        <li>Kcal {{ recipe.macros.perServing.kcal }}</li>
                        <li>Carbs {{ recipe.macros.perServing.carbs }}</li>
                        <li>Protein {{ recipe.macros.perServing.protein }}</li>
                        <li>Fat {{ recipe.macros.perServing.fat }}</li>
                    </ul>
                </div>
            </div>

            <div>
                <h2>{{ 'app.recipe_detail.ingredients' | appTrans }}</h2>

                <ul class="app-recipe_ingredients">
                    <li *ngFor="let ingredient of recipe.ingredients">
                        {{ getMeasurement(ingredient) }} {{ ingredient.product.name }}
                    </li>
                </ul>
            </div>

            <div>
                <h2>{{ 'app.recipe_detail.instruction' | appTrans }}</h2>

                <ol class="app-recipe_instructions">
                    <li *ngFor="let instruction of recipe.instructions">
                        {{ instruction.description }}
                    </li>
                </ol>
            </div>
        </div>
    `,
})
export class RecipeDetailComponent implements OnInit {
    public recipeObservable: Observable<RecipeDetail>;
    private placeholderColor = Math.floor(Math.random() * 16777215).toString(16);

    constructor(private recipeState: RecipeState,
                private activatedRoute: ActivatedRoute) {
    }

    public ngOnInit(): void {
        this.recipeObservable = this.activatedRoute.params
            .switchMap((params) => this.recipeState.getRecipe(params.id))
            .do((recipe) => recipe.ingredients.sort((a, b) => b.kcal - a.kcal))
            .do((recipe) => recipe.description = recipe.description.replace(/\n/g, '<br />'));
    }

    public getMeasurement(ingredient: Ingredient): string {
        if (!ingredient.amount || !ingredient.measurement) {
            return '';
        }

        return `${ingredient.amount} ${ingredient.measurement.name}`;
    }

    // TODO will have to handle and render a collection of photos when real ones get actually shot
    public getPhotos(recipe: RecipeDetail): string {
        if (recipe.photos.length) {
            return recipe.photos[0];
        }

        return `http://placehold.it/400x400/${this.placeholderColor}/fff`;
    }
}
