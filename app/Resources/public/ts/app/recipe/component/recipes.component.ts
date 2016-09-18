import {Component, OnInit} from '@angular/core';
import {RecipeRepository} from "../repository/recipe.repository";
import {Recipe} from "../model/recipe";
import {Router} from "@angular/router";
import {FlashMessageService} from "../../core/service/flash-message.service";
import {FlashMessage} from "../../core/model/flash-message";

@Component({
    selector: 'recipes',
    template: `
        <div class="row">
            <div class="col-xs-12 col-sm-3">
                <div style="height: 400px">
                    <!-- todo filter with toggle for mobile -->
                </div>
            </div>
            <div class="col-xs-12 col-sm-9">
                <div class="row">
                    <div class="col-xs-12 col-sm-6" *ngFor="let recipe of recipes">
                        <a class="thumbnail" (click)="onSelect(recipe)">
                            <img [src]="getImageUrl(recipe)"> 
                            <div class="caption">{{ recipe.name }}</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    `
})
export class RecipesComponent implements OnInit {
    recipes: Recipe[] = [];

    constructor(private recipeRepository: RecipeRepository,
                private router: Router,
                private flashMsgService: FlashMessageService) {}

    ngOnInit(): void {
        this.getRecipes();
    }

    getRecipes(): void {
        this.recipeRepository.getRecipes()
            .subscribe(
                recipes => this.recipes = recipes,
                error => this.flashMsgService.push(new FlashMessage('danger', error))
            );
    }

    onSelect(recipe: Recipe): void {
        this.router.navigate(['/recipes', recipe.id, recipe.name]); // TODO escape spaces in name
    }

    getImageUrl(recipe: Recipe): string {
        return recipe.thumbnail
            ? recipe.thumbnail.path
            : 'http://placehold.it/400x300';
    }
}
