import {Component, OnInit} from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import {ReplaySubject} from 'rxjs/ReplaySubject';
import {Ingredient} from '../model/ingredient';
import {RecipeDetail} from '../model/recipe-detail';
import {RecipeRepository} from '../repository/recipe.repository';

@Component({
    template: `
        <div *ngIf="recipeSubject|async as recipe">
            <div class="app-recipe-detail">
                <h1>{{recipe.name}}</h1>

                <img class="app-recipe-detail__image"
                     [src]="getImageUrl(recipe)">

                <mat-tab-group>
                    <mat-tab [label]="'app.recipe.ingredients'|trans">
                        <mat-list>
                            <mat-list-item *ngFor="let ingredient of recipe.ingredients">
                                {{getMeasurement(ingredient)}} {{ingredient.product.name}}
                            </mat-list-item>
                        </mat-list>
                    </mat-tab>

                    <mat-tab [label]="'app.recipe.cooking'|trans">
                        <mat-list>
                            <mat-list-item *ngFor="let cooking of recipe.cookings">
                                {{cooking.description}}
                            </mat-list-item>
                        </mat-list>
                    </mat-tab>
                </mat-tab-group>
            </div>
        </div>
    `,
})
export class RecipeDetailComponent implements OnInit {
    public recipeSubject = new ReplaySubject<RecipeDetail>(1);
    private readonly idQuery = 'id';

    constructor(private recipeRepository: RecipeRepository,
                private activatedRoute: ActivatedRoute) {
    }

    public ngOnInit(): void {
        this.activatedRoute.params
            .switchMap((params) => this.recipeRepository.getRecipe(+params[this.idQuery]))
            .do((recipe) => recipe.ingredients.sort((a, b) => b.kcal - a.kcal))
            .subscribe(this.recipeSubject);
    }

    public getMeasurement(ingredient: Ingredient): string {
        if (!ingredient.amount || !ingredient.measurement) {
            return '';
        }

        return ingredient.amount + ingredient.measurement.name;
    }

    public getImageUrl(recipe: RecipeDetail): string {
        return (recipe.thumbnail && recipe.thumbnail.path) || 'http://placehold.it/400x400';
    }
}
