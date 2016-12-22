import {Ingredient} from './ingredient';
import {Photo} from './photo';
import {Cooking} from './cooking';
import {Macros} from './macros';
import {RecipeDto} from "./dto/recipe.dto";

export class Recipe {
    id: number;
    name: string;
    isVegan: boolean;
    macros: Macros;
    created: Date;
    updated: Date;
    thumbnail?: Photo;
    photos?: Photo;
    ingredients?: Ingredient[];
    cookings?: Cooking[];

    constructor(dto: RecipeDto) {
        this.id = dto.id;
        this.name = dto.name;
        this.isVegan = dto.isVegan;
        this.macros = dto.macros;
        this.created = new Date(dto.created);
        this.updated = new Date(dto.updated);
        this.thumbnail = dto.thumbnail;
        this.photos = dto.photos;
        this.ingredients = dto.ingredients;
        this.cookings = dto.cookings;
    }
}
