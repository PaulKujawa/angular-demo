import {Component} from '@angular/core';
import {Router} from '@angular/router';
import {Recipe} from '../model/recipe';
import {RecipeState} from '../service/recipe.state';

@Component({
    template: `
        <div class="row">
            <div class="col-xs-12">
                <recipe-filter></recipe-filter>
            </div>
        </div>

        <div *ngIf="recipeState.getPageable()|async as recipes"
             class="row">

            <div *ngFor="let recipe of recipes.docs"
                  class="col-xs-12 col-sm-6 col-md-3" style="margin-bottom: 30px">
                <mat-card (click)="onClick(recipe)"
                          [style.cursor]="'pointer'">
                    <mat-card-header>
                        <mat-card-title>{{recipe.name}}</mat-card-title>
                        <mat-card-subtitle>{{recipe.updated | date}}</mat-card-subtitle>
                    </mat-card-header>
    
                    <img mat-card-image
                         [src]="getImageUrl(recipe)"
                         [attr.alt]="recipe.name">
    
                    <mat-card-content>
                        <macro-chart [macros]="recipe.macros">
                        </macro-chart>
                    </mat-card-content>
                </mat-card>
            </div>

            <div class="col-xs-12">
                <pagination class="pull-right">
                </pagination>
            </div>
        </div>
    `,
})
export class RecipeListComponent {
    constructor(public recipeState: RecipeState,
                private router: Router) {
    }

    public onClick(recipe: Recipe): void {
        const recipeName = recipe.name.replace(' ', '-');
        this.router.navigate(['/recipes', recipe.id, recipeName]);
    }

    public getImageUrl(recipe: Recipe): string {
        return recipe.thumbnail
            ? recipe.thumbnail.path
            : 'http://placehold.it/400x300';
    }
}
