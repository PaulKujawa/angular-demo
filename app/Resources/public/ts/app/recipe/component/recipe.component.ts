import {Component, OnInit} from '@angular/core';
import {ActivatedRoute, Params} from "@angular/router";
import {RecipeRepository} from "../repository/recipe.repository";
import {Recipe} from "../model/recipe";
import {FlashMessageService} from "../../core/service/flash-message.service";
import {FlashMessage} from "../../core/model/flash-message";
import {Ingredient} from "../model/ingredient";

// TODO use e.g. ng2-charts for macros

@Component({
    selector: 'recipe',
    template: `
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <img class="img-circle center-block img-responsive" [src]="getImageUrl()">
            </div>

            <div id="macros" class="col-xs-12 col-md-6">
                {{ recipe?.macros|json }}
                <!--<canvas class="center-block" width="301px" height="301px"></canvas>-->
                <!--<span class="badge" title="Kcal">macros.kcal</span>-->
            </div>
        </div>
        
        <h1 class="text-center">{{ recipe?.name }}</h1>
        <ul id="productList" class="list-unstyled text-center">
            <li *ngFor="let ingredient of recipe?.ingredients">
                {{ getMeasuredIngredient(ingredient) }}
            </li>
        </ul>
        
         <ol id="cookingList" class="text-center">
            <li *ngFor="let cooking of recipe?.cookings">
                {{ cooking.description }}
            </li>
        </ol>
    `
})
export class RecipeComponent implements OnInit {
    recipe: Recipe;

    constructor(private recipeRepository: RecipeRepository,
                private activatedRoute: ActivatedRoute,
                private flashMsgService: FlashMessageService) {}


    ngOnInit(): void {
        this.activatedRoute.params.forEach((params: Params) => {
            this.getRecipe(+params['id']);
        });

    }

    getMeasuredIngredient(ingredient: Ingredient): string {
        return ingredient.amount
            ? this.formatMeasuredIngredient(ingredient)
            : ingredient.product.name;
    }

    getRecipe(id: number): void {
        this.recipeRepository.getRecipe(id)
            .subscribe(
                recipe => this.recipe = recipe,
                error => this.flashMsgService.push(new FlashMessage('danger', error))
            );
    }

    getImageUrl(): string {
        return this.recipe && this.recipe.thumbnail
            ? this.recipe.thumbnail.path
            : 'http://placehold.it/400x400';
    }

    private formatMeasuredIngredient(ingredient: Ingredient): string {
        return ingredient.product.name + ' (' + ingredient.amount + ingredient.measurement.name + ')';
    }
}
