import {RecipeDto} from 'app/recipe/model/dto/recipe.dto';
import {Macros} from 'app/recipe/model/macros';

export class Recipe {
    public id: number;
    public name: string;
    public isVegan: boolean;
    public macros: Macros;
    public servings: number;
    public preparationTime?: number; // TODO mark as required ASAP
    public cookTime?: number; // TODO mark as required ASAP
    public photos: string[];
    public created: Date;
    public updated: Date;

    constructor(dto: RecipeDto) {
        this.id = dto.id;
        this.name = dto.name;
        this.isVegan = dto.is_vegan;
        this.macros = new Macros(dto.macros, dto.servings);
        this.servings = dto.servings;
        this.preparationTime = dto.preparation_time;
        this.cookTime = dto.cook_time;
        this.created = new Date(dto.created);
        this.updated = new Date(dto.updated);

        // workaround as the image folder works w/o the base url (_locale).
        this.photos = dto.photos.map((photo) => `../${photo}`);
    }

    public hasTime(): boolean {
        return !!(this.cookTime || this.preparationTime);
    }
}
