import {Macros} from '../macros';
import {Photo} from '../photo';

export interface RecipeResponseDto {
    id: number;
    name: string;
    is_vegan: boolean;
    macros: Macros;
    servings?: number;
    preparation_time?: number;
    cook_time?: number;
    thumbnail?: Photo;
    created: string;
    updated: string;
}
