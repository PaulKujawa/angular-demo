import {Component} from '@angular/core';
import {Router} from '@angular/router';
import {Recipe} from 'app/recipe/model/recipe';
import {RecipeState} from 'app/recipe/service/recipe.state';

@Component({
    template: `
        <app-recipe-filter></app-recipe-filter>

        <div *ngIf="recipeState.getPageable()|async as recipes"
             class="app-recipe-list">
            <mat-card *ngFor="let recipe of recipes.docs"
                      (click)="onClick(recipe)"
                      class="app-recipe-list__card">
                <mat-card-header>
                    <mat-card-title>{{ recipe.name }}</mat-card-title>
                </mat-card-header>

                <img appLazyImg
                     [lazyImgSrc]="getThumbnail(recipe)"
                     mat-card-image
                     [attr.alt]="recipe.name">

                <mat-card-content>
                    <app-recipe-facts [recipe]="recipe">
                    </app-recipe-facts>
                </mat-card-content>
            </mat-card>
        </div>

        <app-pagination></app-pagination>
    `,
})
export class RecipeListComponent {
    public readonly placeholderUrl = 'http://placehold.it/400x400/b2dfdb/fff';

    constructor(public recipeState: RecipeState,
                private router: Router) {
    }

    public onClick(recipe: Recipe): void {
        const recipeName = recipe.name.replace(/\s/g, '-');

        this.router.navigate(['/recipes', recipe.id, recipeName]);
    }

    public getThumbnail(recipe: Recipe): string {
        if (recipe.photos.length) {
            return recipe.photos[0];
        }

        return this.placeholderUrl;
    }
}
