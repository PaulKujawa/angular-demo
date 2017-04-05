import {RecipeResponseDto} from './dto/recipe-list-response.dto';
import {Macros} from './macros';
import {Photo} from './photo';

export class Recipe {
    id: number;
    name: string;
    isVegan: boolean;
    macros: Macros;
    thumbnail?: Photo;
    created: Date;
    updated: Date;

    constructor(dto: RecipeResponseDto) {
        this.id = dto.id;
        this.name = dto.name;
        this.isVegan = dto.isVegan;
        this.macros = dto.macros;
        this.thumbnail = dto.thumbnail;
        this.created = new Date(dto.created);
        this.updated = new Date(dto.updated);
    }
}
