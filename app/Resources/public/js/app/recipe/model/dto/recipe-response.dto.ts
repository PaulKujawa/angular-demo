import {MacrosDto} from './macros.dto';
import {PhotoDto} from './photo.dto';

export interface RecipeResponseDto {
    id: number;
    name: string;
    is_vegan: boolean;
    macros: MacrosDto;
    servings: number;
    preparation_time?: number;
    cook_time?: number;
    thumbnail?: PhotoDto;
    created: string;
    updated: string;
}
