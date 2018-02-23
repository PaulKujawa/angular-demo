import {Component} from '@angular/core';
import {Router} from '@angular/router';
import {Recipe} from '../model/recipe';
import {RecipeState} from '../service/recipe.state';

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

                <img mat-card-image
                     [src]="getThumbnail(recipe)"
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
    constructor(public recipeState: RecipeState,
                private router: Router) {
    }

    public onClick(recipe: Recipe): void {
        const recipeName = recipe.name.replace(/\s/g, '-');

        this.router.navigate(['/recipes', recipe.id, recipeName]);
    }

    public getThumbnail(recipe: Recipe): string {
        if (recipe.thumbnail) {
            return recipe.thumbnail.path;
        }

        const placeholderColor = Math.floor(Math.random() * 16777215).toString(16);

        return `http://placehold.it/400x400/${placeholderColor}/fff`;
    }
}
