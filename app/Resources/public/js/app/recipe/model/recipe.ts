import {RecipeResponseDto} from './dto/recipe-response.dto';
import {Macros} from './macros';
import {Photo} from './photo';

export class Recipe {
    public id: number;
    public name: string;
    public isVegan: boolean;
    public macros: Macros;
    public servings?: number;
    public preratationTime?: number; // TODO mark as required ASAP
    public thumbnail?: Photo;
    public created: Date;
    public updated: Date;

    constructor(dto: RecipeResponseDto) {
        this.id = dto.id;
        this.name = dto.name;
        this.isVegan = dto.isVegan;
        this.macros = dto.macros;
        this.servings = dto.servings;
        this.preratationTime = dto.preparationTime;
        this.thumbnail = dto.thumbnail;
        this.created = new Date(dto.created);
        this.updated = new Date(dto.updated);
    }
}
