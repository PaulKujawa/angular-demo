import {Component, OnInit} from '@angular/core';
import {Router} from '@angular/router';
import {Subject} from 'rxjs/Subject';
import {Pageable} from '../../core/model/pageable';
import {FilterParameter} from '../../shared/service/filter.service';
import {Recipe} from '../model/recipe';
import {RecipeRepository} from '../repository/recipe.repository';

@Component({
    template: `
        <div class="row">
            <div class="col-xs-12">
                <recipe-filter [pagination]="pageable?.pagination"
                               (filter)="onFilter($event)">
                </recipe-filter>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4"
                 *ngFor="let recipe of pageable?.docs">
                <div class="thumbnail"
                     [style.cursor]="'pointer'"
                     (click)="onSelectRecipe(recipe)">
                    <h2 class="media-heading">{{recipe.name}}</h2>
                    <img [src]="getImageUrl(recipe)">
                    <macro-chart [macros]="recipe.macros"></macro-chart>
                    <div class="caption">
                        <span>
                            <i>{{recipe.updated | date}}</i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    `,
})
export class RecipeListComponent implements OnInit {
    public pageable: Pageable<Recipe>;
    private filterStream = new Subject<FilterParameter>();

    constructor(private router: Router,
                private recipeRepository: RecipeRepository) {
    }

    public ngOnInit(): void {
        this.filterStream
            .switchMap((queryParams) => this.recipeRepository.getRecipes(queryParams))
            .subscribe((pageable: Pageable<Recipe>) => this.pageable = pageable);
    }

    public onFilter(filterMap: FilterParameter): void {
        this.filterStream.next(filterMap);
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
