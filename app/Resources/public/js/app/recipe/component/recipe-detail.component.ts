import {Component, OnInit} from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import {Observable} from 'rxjs/Observable';
import {Ingredient} from '../model/ingredient';
import {RecipeDetail} from '../model/recipe-detail';
import {RecipeState} from '../service/recipe.state';

@Component({
    template: `
        <div *ngIf="recipeObservable|async as recipe">
            <div class="app-recipe-detail">
                <h1>{{ recipe.name }}</h1>

                <img class="app-recipe-detail__image"
                     [src]="getPhotos(recipe)">

                <mat-tab-group>
                    <mat-tab [label]="'app.recipe.ingredients'|appTrans">
                        <mat-list>
                            <mat-list-item *ngFor="let ingredient of recipe.ingredients">
                                {{ getMeasurement(ingredient) }} {{ ingredient.product.name }}
                            </mat-list-item>
                        </mat-list>
                    </mat-tab>

                    <mat-tab [label]="'app.recipe.cooking'|appTrans">
                        <mat-list>
                            <mat-list-item *ngFor="let cooking of recipe.cookings">
                                {{ cooking.description }}
                            </mat-list-item>
                        </mat-list>
                    </mat-tab>
                </mat-tab-group>
            </div>
        </div>
    `,
})
export class RecipeDetailComponent implements OnInit {
    public recipeObservable: Observable<RecipeDetail>;

    constructor(private recipeState: RecipeState,
                private activatedRoute: ActivatedRoute) {
    }

    public ngOnInit(): void {
        this.recipeObservable = this.activatedRoute.params
            .switchMap((params) => this.recipeState.getRecipe(params.id))
            .do((recipe) => recipe.ingredients.sort((a, b) => b.kcal - a.kcal));
    }

    public getMeasurement(ingredient: Ingredient): string {
        if (!ingredient.amount || !ingredient.measurement) {
            return '';
        }

        return ingredient.amount + ingredient.measurement.name;
    }

    // TODO will have to handle and render a collection of photos when real ones get actually shot
    public getPhotos(recipe: RecipeDetail): string {
        if (recipe.photos.length) {
            return recipe.photos[0].path;
        }

        return 'http://placehold.it/400x400';
    }
}
