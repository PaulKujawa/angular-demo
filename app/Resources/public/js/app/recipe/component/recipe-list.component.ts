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
                 class="col-xs-12 col-sm-6 col-md-4">
                <div class="thumbnail"
                     [style.cursor]="'pointer'"
                     (click)="onSelectRecipe(recipe)">
                    <h2 class="media-heading">{{recipe.name}}</h2>

                    <img [src]="getImageUrl(recipe)">

                    <macro-chart [macros]="recipe.macros"></macro-chart>

                    <div class="caption">
                        <span><i>{{recipe.updated | date}}</i></span>
                    </div>
                </div>
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

    public onSelectRecipe(recipe: Recipe): void {
        const recipeName = recipe.name.replace(' ', '-');
        this.router.navigate(['/recipes', recipe.id, recipeName]);
    }

    public getImageUrl(recipe: Recipe): string {
        return recipe.thumbnail
            ? recipe.thumbnail.path
            : 'http://placehold.it/400x300';
    }
}
