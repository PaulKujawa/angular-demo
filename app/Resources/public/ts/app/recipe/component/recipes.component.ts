import {Component, OnInit} from '@angular/core';
import {Router} from "@angular/router";
import {Subject} from "rxjs/Subject";
import {RecipeRepository} from "../repository/recipe.repository";
import {Recipe} from "../model/recipe";
import {FlashMessageService} from "../../core/service/flash-message.service";
import {FlashMessage} from "../../core/model/flash-message";
import {Recipes} from "../model/pageable/recipes";

@Component({
    selector: 'recipes',
    template: `
        <div class="row">
            <div class="col-xs-12">
                <recipe-filter [pagination]="recipes?.pagination" (filter)="onFilter($event)"></recipe-filter>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="media app-recipes__item" (click)="onSelectRecipe(recipe)" *ngFor="let recipe of recipes?.docs">
                    <div class="media-left app-recipes-item__left">
                        <img class="media-object app-recipes-item__object" [src]="getImageUrl(recipe)"> 
                    </div>
                    <div class="media-body">
                        <h2 class="media-heading">{{ recipe.name }}</h2>
                        <macro-chart [macros]="recipe.macros"></macro-chart>
                    </div>
                </div>
            </div>
        </div>
    `
})
export class RecipesComponent implements OnInit {
    recipes: Recipes;
    private filterStream = new Subject<Map<string, string>>();

    constructor(private router: Router,
                private flashMsgService: FlashMessageService,
                private recipeRepository: RecipeRepository) {}

    ngOnInit(): void {
        this.filterStream
            .switchMap((queryParams: Map<string, string>) => this.recipeRepository.getRecipes(queryParams))
            .subscribe(
                (recipes: Recipes) => this.recipes = recipes,
                (error: string) => this.flashMsgService.push(new FlashMessage('danger', error))
            );
    }

    onFilter(filterMap: Map<string, string>): void {
        this.filterStream.next(filterMap);
    }

    onSelectRecipe(recipe: Recipe): void {
        this.router.navigate(['/recipes', recipe.id, recipe.name]); // TODO escape spaces in name
    }

    getImageUrl(recipe: Recipe): string {
        return recipe.thumbnail
            ? recipe.thumbnail.path
            : 'http://placehold.it/400x300';
    }
}
