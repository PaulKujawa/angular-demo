import {RecipeResponseDto} from './dto/recipe-response.dto';
import {Macros} from './macros';
import {Photo} from './photo';

export class Recipe {
    public id: number;
    public name: string;
    public isVegan: boolean;
    public macros: Macros;
    public servings?: number;
    public preparationTime?: number; // TODO mark as required ASAP
    public cookTime?: number; // TODO mark as required ASAP
    public thumbnail?: Photo;
    public created: Date;
    public updated: Date;

    constructor(dto: RecipeResponseDto) {
        this.id = dto.id;
        this.name = dto.name;
        this.isVegan = dto.is_vegan;
        this.macros = dto.macros;
        this.servings = dto.servings;
        this.preparationTime = dto.preparation_time;
        this.cookTime = dto.cook_time;
        this.thumbnail = dto.thumbnail;
        this.created = new Date(dto.created);
        this.updated = new Date(dto.updated);
    }

    public hasTime(): boolean {
        return !!(this.cookTime || this.preparationTime);
    }
}
