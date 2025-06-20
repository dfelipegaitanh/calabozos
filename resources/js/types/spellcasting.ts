/**
 * Interfaces for spellcasting data
 * Based on the D&D API spellcasting information format
 */

/**
 * Represents a spellcasting ability (e.g., CHA, INT, WIS)
 */
export interface SpellcastingAbility {
    index: string;
    name: string;
    url: string;
    _id: string;
}

/**
 * Represents an individual piece of spellcasting information
 * (e.g., Cantrips, Spell Slots, etc.)
 */
export interface SpellcastingInfoItem {
    _id: string;
    name: string;
    desc: string[];
}

/**
 * Represents the complete spellcasting data for a character class
 */
export interface SpellcastingData {
    level: number;
    spellcasting_ability: SpellcastingAbility;
    info: SpellcastingInfoItem[];
    _id: string;
}
